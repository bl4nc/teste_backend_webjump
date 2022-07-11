<?php

namespace App\DAO;

use App\Model\CategoryModel;

class CategoryDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function InsertCategory(CategoryModel $category): CategoryModel
    {
        $query = "INSERT INTO category (name) VALUES (:name)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "name" => $category->getName(),
        ]);
        $category->setCode($this->pdo->lastInsertId());
        return $category;
    }

    public function DeleteCategory(int $category): bool
    {
        $query = "DELETE from category where code = :code";
        $statement = $this->pdo->prepare($query);
        $statement = $statement->execute([
            "code" => $category,
        ]);
        return $statement;
    }

    public function UpdateCategory(CategoryModel $category)
    {
        $query = "UPDATE category set name = :name, updated_at = (datetime('now','localtime')) 
        where code = :code";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "code" => $category->getCode(),
            "name" => $category->getName(),
        ]);
        return $statement;
    }

    public function SelectUniqueCategory(string $code): array
    {
        $query = "SELECT * from category where code = :code limit 1";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "code" => $code,
        ]);
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }

    public function SelectAllCategory(): array
    {
        $query = "SELECT * from category";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }

    public function SelectCategories(string $codes): array
    {
        $query = "SELECT * from category where code in ($codes)";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }
}
