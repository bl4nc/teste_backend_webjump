<?php

namespace App\DAO;

use App\Model\ProductModel;

class ProductDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function InsertProduct(ProductModel $product): array
    {
        $query = "INSERT INTO product (sku,product_name,price,description,quantity,category,picture) 
        VALUES (:sku,:product_name,:price,:description,:quantity,:category,:picture)";
        $statement = $this->pdo->prepare($query);
        try {
            $statement->execute([
                "sku" => $product->getSKU(),
                "product_name" => $product->getProductName(),
                "price" => $product->getPrice(),
                "quantity" => $product->getQuantity(),
                "category" => $product->getCategory(),
                "description" => $product->getDescription() ?? NULL,
                "picture" => $product->getPicture() ?? NULL
            ]);
            return array(
                "success" => true,
                "message" => 'Inserted.'
            );
        } catch (\Throwable $th) {
            return array(
                "success" => false,
                "err_code" => $th->getCode(),
                "err_message" => $th->getMessage()
            );
        }
        return $product;
    }

    public function DeleteProduct(string $sku): bool
    {
        $query = "DELETE from product where sku = :sku";
        $statement = $this->pdo->prepare($query);
        $statement = $statement->execute([
            "sku" => $sku,
        ]);
        return $statement;
    }

    public function UpdateProduct(ProductModel $product)
    {
        $query = "UPDATE product set product_name = :product_name, 
        price = :price,description = :description,quantity = :quantity,
        category = :category, picture = :picture,
        updated_at = (datetime('now','localtime')) 
        where sku = :sku";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "sku" => $product->getSKU(),
            "product_name" => $product->getProductName(),
            "price" => $product->getPrice(),
            "description" => $product->getDescription(),
            "quantity" => $product->getQuantity(),
            "category" => $product->getCategory(),
            "picture" => $product->getPicture(),
        ]);
        return $statement;
    }

    public function RemovePicture(string $sku)
    {
        $query = "UPDATE product set picture = NULL
        where sku = :sku";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "sku" => $sku
        ]);
        return $statement;
    }

    public function SelectUniqueProduct(string $sku): array
    {
        $query = "SELECT * from product where sku = :sku limit 1";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            "sku" => $sku,
        ]);
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }

    public function SelectAllProducts(): array
    {
        $query = "SELECT * from product";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }


    public function SelectCategories(): array
    {
        $query = "SELECT * from Product";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }

    public function SelectProducts(string $skus): array
    {
        $query = "SELECT * from product where sku in ($skus)";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }
}
