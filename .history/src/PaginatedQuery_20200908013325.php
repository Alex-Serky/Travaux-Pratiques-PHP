<?php

namespace App;

use PDO;
use Exception;
use App\Connexion;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;

    public function __construct(
        string $query,
        string $queryCount,
        string $classMapping,
        ?\PDO $pdo = null,
        int $perPage = 12
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo ?: Connexion::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(): array
    {
        $currentPage = $this->getCurrentPage();
        $count = (int)$this->pdo
            ->query($this->query)
            ->fetch(PDO::FETCH_NUM)[0];
        $pages = ceil($count / $this->perPage);
        if ($currentPage > $pages) {
            throw new Exception('Cette page n\'existe pas.');
        }
        $offset = $this->perPage * ($currentPage - 1);
        return $this->pdo->query(
            $this->query .
            " LIMIT {$this->perPage} OFFSET $offset"
            )
            ->fetchAll(PDO::FETCH_CLASS, $this->classMapping);
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary ml-auto">&laquo; Page précédente</a>
HTML;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }
}