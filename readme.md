# :rocket: Teste Backend WEBJUMP

## :pushpin: Desafio proposto

Criar dois cruds utilizando a versão mais atual do PHP um para produtos e outro para categorias.

### :no_good: O que foi usado para execução do projeto

- Docker para criação do ambiente da aplicação.
- Nginx para servidor Web e balanceamento de carga da aplicação.
- PHP na versão 8.1.7.

#### 💻 Pré-requisitos

Para rodar a API é necessário ter o Composer, Docker e o Docker-compose instalados e configurados na maquina.

Primeiro clone o repositorio e rode o comando para atualizar as dependencias e namespaces do composer na pasta do repositorio.
```shell
composer install
```
Apos a instalação é só rodar o comando:

```shell
docker-compose up -d --build
```

---

## Insomnia

[![Run in Insomnia}](https://insomnia.rest/images/run.svg)](https://insomnia.rest/run/?label=TesteBackend%20Webjump&uri=https%3A%2F%2Fbitbucket.org%2Ffae_u%2Fassessment-backend-xp%2Fraw%2Fb0b6fd6ddc224222dcf0ec73efb3c88a02449cd0%2FInsomnia_collection.json)

### :star: Rotas

#### Category Controller

---

##### Inserir categoria

**Método** : `POST`
**URL** : `api/insert_category`
**Parâmetros Obrigatórios** : body

- É necessário enviar um JSON no body da req com o nome da categoria.:

```json
{
  "name": "Adidas"
}
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
  "success":true,
  "message": "Inserted"
}
```

---

##### Deletar categoria

**Método** : `DELETE`
**URL** : `api/delete_category`
**Parâmetros Obrigatórios** : body

- É necessário enviar um JSON no body da req com o nome da categoria.:

```json
{
  "code": "9"
}
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
  "success":true,
  "message": "Deleted"
}
```

---

##### Atualizar categoria

**Método** : `PUT`
**URL** : `api/update_category`
**Parâmetros Obrigatórios** : body

- É necessário enviar um JSON no body da req com o nome da categoria.:

```json
{
  "code": "9",
  "name": "Nike"
}
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
  "success":true,
  "message": "Updated."
}
```

---

##### Selecionar categoria

**Método** : `GET`
**URL** : `api/select_unique_category`
**Parâmetros Obrigatórios** : query

- É necessário enviar o `code` como queryParam:

```url
api/select_unique_category?code=8
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "category": {
  "code": "8",
  "name": "Adidas",
  "created_at": "2022-06-20 04:34:35",
  "updated_at": "2022-06-20 15:48:47"
 }
}
```

---

##### Selecionar varias categorias

**Método** : `GET`
**URL** : `api/select_unique_category`
**Parâmetros Obrigatórios** : query

- É necessário enviar o `codes[]` como queryParam:

```url
api/select_categories?codes[]=8&codes[]=9
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "categories": [
  {
   "code": 8,
   "name": "Adidas",
   "created_at": "2022-06-19 09:35:32",
   "updated_at": "2022-06-19 09:37:52"
  },
  {
   "code": 9,
   "name": "Nike",
   "created_at": "2022-06-19 09:35:32",
   "updated_at": "2022-06-19 09:37:52"
  }
 ]
}
```

---

##### Selecionar todas categorias

**Método** : `GET`
**URL** : `api/select_all_category`
**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "categories": [
  {
   "code": 4,
   "name": "Adidas",
   "created_at": "2022-06-19 09:35:32",
   "updated_at": "2022-06-19 09:37:52"
  },
  {
   "code": 5,
   "name": "Nike",
   "created_at": "2022-06-19 09:35:35",
   "updated_at": null
  },
  {
   "code": 6,
   "name": "Nike",
   "created_at": "2022-06-19 09:35:36",
   "updated_at": null
  },
  {
   "code": 8,
   "name": "Adidas",
   "created_at": "2022-06-20 04:34:35",
   "updated_at": "2022-06-20 15:48:47"
  }
 ]
}
```

---

#### Product Controller

---

##### Inserir produto

**Método** : `POST`
**Tipo do body**: `multipart`
**URL** : `api/insert_product`
**Parâmetros Obrigatórios** : `name,sku,quantity,price,category[]`
**Parâmetros Opcionais** : `description,picture`
**OBS**

- Para adicionar mais de uma categoria no produto só adicionar mais campos `category[]` na requisição.
- Para enviar uma foto deve ser enviado o arquivo no parâmetro `picture`.

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
  "success":true,
  "message": "Inserted"
}
```

---

##### Deletar produto

**Método** : `DELETE`
**URL** : `api/delete_product`
**Parâmetros Obrigatórios** : body

```json
{
 "sku":"42254-011"
}
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
  "success":true,
  "message": "Deleted"
}
```

---

##### Atualizar produto

**Método** : `POST`
**URL** : `api/update_product`
**Tipo do body**: `multipart`
**Parâmetros Obrigatórios** : `name,sku`
**Parâmetros Opcionais** : `,quantity,price,category[],description,picture`
**OBS**

- Para adicionar mais de uma categoria no produto só adicionar mais campos `category[]` na requisição.
- Para enviar uma foto deve ser enviado o arquivo no parâmetro `picture`.

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "message": "Updated product"
}

```

---

##### Remover imagem do produto

**Método** : `PUT`
**URL** : `api/remove_picture`
**Parâmetros Obrigatórios** : body

```json
{
 "sku":"42254-0111"
}
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "message": "Picture removed."
}
```

---

##### Selecionar produto

**Método** : `GET`
**URL** : `api/select_unique_product`
**Parâmetros Obrigatórios** : query

- É necessário enviar o `sku` como queryParam:

```url
api/select_unique_category?sku=42254-011
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "product": {
  "sku": "42254-011",
  "product_name": "Eplerenone",
  "price": 2300.39,
  "description": "Bypass Innominate Artery to Bilateral Upper Leg Artery with Synthetic Substitute, Open Approach",
  "quantity": 59,
  "category": "4,5,6",
  "picture": "eec81171-4a48-4526-ad32-40ff2df21301.png",
  "created_at": "2022-06-20 20:26:50",
  "updated_at": null
 }
}
```

---

##### Selecionar vários produtos

**Método** : `GET`
**URL** : `api/select_products`
**Parâmetros Obrigatórios** : query

- É necessário enviar o `sku[]` como queryParam:

```url
api/select_categories?sku[]=42254-011&sku[]=42254-0111
```

**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "categories": [
  {
   "sku": "42254-011",
   "product_name": "Eplerenone",
   "price": 2300.39,
   "description": "Bypass Innominate Artery to Bilateral Upper Leg Artery with Synthetic Substitute, Open Approach",
   "quantity": 59,
   "category": "4,5,6",
   "picture": "eec81171-4a48-4526-ad32-40ff2df21301.png",
   "created_at": "2022-06-20 20:26:50",
   "updated_at": null
  },
  {
   "sku": "42254-0111",
   "product_name": "Eplerenone",
   "price": 2300.39,
   "description": "Bypass Innominate Artery to Bilateral Upper Leg Artery with Synthetic Substitute, Open Approach",
   "quantity": 59,
   "category": "4,5,6",
   "picture": "bb0aac96-718c-496a-86c1-52e7473d9dfd.png",
   "created_at": "2022-06-20 20:58:14",
   "updated_at": null
  }
 ]
}
```

---

##### Selecionar todas os produtos

**Método** : `GET`
**URL** : `api/select_all_products`
**Retorno** : `JSON` </br>
**Status Code** : `200`</br>
**Response**:

```json
{
 "success": true,
 "products": [
  {
   "sku": "42254-011",
   "product_name": "Eplerenone",
   "price": 2300.39,
   "description": "Bypass Innominate Artery to Bilateral Upper Leg Artery with Synthetic Substitute, Open Approach",
   "quantity": 59,
   "category": "4,5,6",
   "picture": "eec81171-4a48-4526-ad32-40ff2df21301.png",
   "created_at": "2022-06-20 20:26:50",
   "updated_at": null
  },
  {
   "sku": "42254-0111",
   "product_name": "Eplerenone",
   "price": 2300.39,
   "description": "Bypass Innominate Artery to Bilateral Upper Leg Artery with Synthetic Substitute, Open Approach",
   "quantity": 59,
   "category": "4,5,6",
   "picture": "bb0aac96-718c-496a-86c1-52e7473d9dfd.png",
   "created_at": "2022-06-20 20:58:14",
   "updated_at": null
  }
 ]
}
```
