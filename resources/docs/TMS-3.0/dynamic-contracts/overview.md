# Dynamic Contracts

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the dynamic contract object.
title | string | The unique title of the dynamic contract.
active | boolean | Determines if the dynamic contract is active or not.

<a name="index"></a>
## Index

This endpoint indexes all dynamic contracts in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/dynamic-contracts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
active  <small>(url param)</small> | boolean | No | Get only active or inactive dynamic contracts.
has_tasks  <small>(url param)</small> | boolean | No | Get only dynamic contracts that have or have no task templates linked to them.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/dynamic-contracts?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": [
        {
            "id": 1,
            "title": "Avvikling av aksjeselskap",
            "active": true
        },
        {
            "id": 2,
            "title": "Kontroll av prosjektregnskap/ Innovasjon Norge",
            "active": true
        },
        {
            "id": 3,
            "title": "Some other dynamic contract",
            "active": false
        }
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/dynamic-contracts?page=1",
        "last": "https://{environment}.synega.com/api/v3/dynamic-contracts?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "Previous",
                "active": false
            },
            {
                "url": "https://{environment}.synega.com/api/v3/dynamic-contracts?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next",
                "active": false
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/dynamic-contracts",
        "per_page": 25,
        "to": 2,
        "total": 2
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a dynamic contract in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/dynamic-contracts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
title | string | **Yes** | The title of the dynamic contract.
active | boolean | No | Determines if the dynamic contract is active or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/dynamic-contracts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "title": "New Dynamic Contract"
    }'
```

### Example Response

```json
{
    "data": {
        "id": 5,
        "title": "New Dynamic Contract",
        "active": true
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific dynamic contract.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
dynamic_contract_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the dynamic contract.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 5,
        "title": "New Dynamic Contract",
        "active": true
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a dynamic contract.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
dynamic_contract_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the dynamic contract.
title | string | No | The title of the dynamic contract.
active | boolean | No | Determines if the dynamic contract is active or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "title": "Updated Title",
       "active": false
    }'
```

### Example Response

```json
{
    "data": {
        "id": 5,
        "title": "Updated Title",
        "active": false
    }
}
```

<a name="delete"></a>
## Delete

This endpoint deleted a specific dynamic contract.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
dynamic_contract_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the dynamic contract.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/dynamic-contracts/{dynamic_contract_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```
