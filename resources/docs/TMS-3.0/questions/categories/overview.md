# Question Categories

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the question category object.
title | string | The title of the question category.

<a name="index"></a>
## Index

This endpoint indexes all question categories in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/question-categories`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/question-categories?page=1 \
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
            "title": "Untitled category"
        },
        {
            "id": 2,
            "title": "Specific questions"
        },
        {
            "id": 3,
            "title": "Common questions"
        }
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/question-categories?page=1",
        "last": "https://{environment}.synega.com/api/v3/question-categories?page=1",
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
                "url": "https://{environment}.synega.com/api/v3/question-categories?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next",
                "active": false
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/question-categories",
        "per_page": 25,
        "to": 3,
        "total": 3
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a question category in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/question-categories`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
title | string | **Yes** | The title of the question category.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/question-categories \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "title": "Deprecated questions"
    }'
```

### Example Response

```json
{
    "data": {
        "id": 4,
        "title": "Deprecated questions"
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific question category.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/question-categories/{category_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
category_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question category.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/question-categories/{category_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "title": "Untitled"
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a question category.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/question-categories/{category_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
category_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question category.
title | string | **Yes** | The title of the question category.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/question-categories/{category_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "title": "Titled"
    }'
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "title": "Titled"
    }
}
```

<a name="delete"></a>
## Delete

This endpoint deleted a specific question category.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/question-categories/{category_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
category_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question category.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/question-categories/{category_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```


