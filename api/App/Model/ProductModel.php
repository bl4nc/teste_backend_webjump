<?php

namespace App\Model;

final class ProductModel
{
        private string $product_name;
        private string $SKU;
        private float $price;
        private string $description;
        private int $quantity;
        private string|null $picture;
        private string $category;
        private string $created_at;
        private string $updated_at;

        public function __construct(string $product_name, string $SKU, float $price, string $description, int $quantity,string $category,string $picture)
        {
                $this->product_name = $product_name;
                $this->SKU = $SKU;
                $this->price = $price;
                $this->description = $description;
                $this->quantity = $quantity;
                $this->category = $category;
                $this->picture = $picture;
        }

        /**
         * Get the value of product_name
         */
        public function getProductName(): string
        {
                return $this->product_name;
        }

        /**
         * Set the value of product_name
         */
        public function setProductName(string $product_name): self
        {
                $this->product_name = $product_name;

                return $this;
        }

        /**
         * Get the value of SKU
         */
        public function getSKU(): string
        {
                return $this->SKU;
        }

        /**
         * Set the value of SKU
         */
        public function setSKU(string $SKU): self
        {
                $this->SKU = $SKU;

                return $this;
        }

        /**
         * Get the value of price
         */
        public function getPrice(): float
        {
                return $this->price;
        }

        /**
         * Set the value of price
         */
        public function setPrice(float $price): self
        {
                $this->price = $price;

                return $this;
        }

        /**
         * Get the value of description
         */
        public function getDescription(): string
        {
                return $this->description;
        }

        /**
         * Set the value of description
         */
        public function setDescription(string $description): self
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of quantity
         */
        public function getQuantity(): int
        {
                return $this->quantity;
        }

        /**
         * Set the value of quantity
         */
        public function setQuantity(int $quantity): self
        {
                $this->quantity = $quantity;

                return $this;
        }

        /**
         * Get the value of category
         */
        public function getCategory(): string
        {
                return $this->category;
        }

        /**
         * Set the value of category
         */
        public function setCategory(array $category): self
        {
                $this->category = $category;

                return $this;
        }

        /**
         * Get the value of created_at
         */
        public function getCreatedAt(): string
        {
                return $this->created_at;
        }

        /**
         * Set the value of created_at
         */
        public function setCreatedAt(string $created_at): self
        {
                $this->created_at = $created_at;

                return $this;
        }

        /**
         * Get the value of updated_at
         */
        public function getUpdatedAt(): string
        {
                return $this->updated_at;
        }

        /**
         * Set the value of updated_at
         */
        public function setUpdatedAt(string $updated_at): self
        {
                $this->updated_at = $updated_at;

                return $this;
        }

        /**
         * Get the value of picture
         */
        public function getPicture(): string
        {
                return $this->picture;
        }

        /**
         * Set the value of picture
         */
        public function setPicture(string $picture): self
        {
                $this->picture = $picture;

                return $this;
        }
}
