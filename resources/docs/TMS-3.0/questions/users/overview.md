# Question Users

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the question user object.
name | string | The name of the user who asked a question.
email | string | The email address of the user who asked a question.
phone | int | The phone number of the user who asked a question.

<a name="index"></a>
## Index

This endpoint indexes all question users in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/question-users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
phone | int | No | The exact phone number of the user who asked a question.
email | string | No | The exact email address of the user who asked a question.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/question-users?page=1 \
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
            "name": "John Smith",
            "email": "john@example.com",
            "phone": 4712341234
        },
        {
            "id": 2,
            "name": "Yeti Johnson",
            "email": "yeti@example.com",
            "phone": 4712345123
        },
        {
            "id": 3,
            "name": "Katy Perry",
            "email": "katy_perry@example.com",
            "phone": 4712345612
        }
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/question-users?page=1",
        "last": "https://{environment}.synega.com/api/v3/question-users?page=1",
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
                "url": "https://{environment}.synega.com/api/v3/question-users?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next",
                "active": false
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/question-users",
        "per_page": 25,
        "to": 3,
        "total": 3
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a question user in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/question-users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The name of the question user.
phone | int | No (required if no email provided) | The phone number of the question user. Must be a valid E.164 phone number.
email | string | No (required if no phone provided) | The email address of the question user. Must be a valid email address.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/question-users \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "Andrew Scatter",
        "email": "andrew@example.com",
        "phone": 4712345612
    }'
```

### Example Response

```json
{
    "data": {
        "id": 4,
        "name": "Andrew Scatter",
        "email": "andrew@example.com",
        "phone": 4712345612
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific question user.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/question-users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question user.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/question-users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "name": "Yester Nath",
        "email": "yester@example.com",
        "phone": 4712345614
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a question user.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/question-users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question user.
name | string | No | The name of the question user.
phone | int | No | The phone number of the question user. Must be a valid E.164 phone number.
email | string | No | The email address of the question user. Must be a valid email address.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/question-users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "phone": 4712345612
    }'
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "name": "Yester Nath",
        "email": "y@nat.com",
        "phone": 4712345612
    }
}
```

<a name="delete"></a>
## Delete

This endpoint deleted a specific question user.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/question-users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question user.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/question-users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```


