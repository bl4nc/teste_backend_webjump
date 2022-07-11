<?php

namespace App\Model;

final class CategoryModel
{
        private string $code;
        private string $name;
        private string $created_at;
        private string $updated_at;

        public function __construct(string $name)
        {
                $this->name = $name;
        }


        /**
         * Get the value of code
         */
        public function getCode(): string
        {
                return $this->code;
        }

        /**
         * Set the value of code
         */
        public function setCode(string $code): self
        {
                $this->code = $code;

                return $this;
        }

        /**
         * Get the value of name
         */
        public function getName(): string
        {
                return $this->name;
        }

        /**
         * Set the value of name
         */
        public function setName(string $name): self
        {
                $this->name = $name;
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
         * Return all category data
         */

        public function getAllCategoryData(): array
        {
                return array(
                        "code" => $this->code,
                        "name" => $this->name,
                        "created_at" => $this->created_at ?? '',
                        "updated_at" => $this->updated_at ?? '',
                );
        }
}
