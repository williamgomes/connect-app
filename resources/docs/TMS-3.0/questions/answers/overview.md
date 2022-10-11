# Question Answers

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the question answer object.
user_id | integer | The user ID of answer author.
question_id | string | The ID of the question which the answer was given to.
answer | string | The actual answer content.

<a name="index"></a>
## Index

This endpoint indexes all question answers in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/questions/{question_id}/answers`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question which the answer should answer to.
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/questions/{question_id}/answers?page=1 \
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
            "answer": "Nothing",
            "created_at": "2020-10-13 15:53:23",
            "user": {
                "id": 1,
                "active": true,
                "name": "John Doe",
                "email": "john.doe@synega.com",
                "phone": 4712341234,
                "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>",
                "profile_picture_url": "url-to-profile"
            }
        },
        {
            "id": 2,
            "answer": "Hahaha",
            "created_at": "2020-10-13 16:13:16",
            "user": {
                "id": 1,
                "active": true,
                "name": "John Doe",
                "email": "john.doe@synega.com",
                "phone": 4712341234,
                "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>",
                "profile_picture_url": "url-to-profile"
            }
        }
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/questions/1/answers?page=1",
        "last": "https://{environment}.synega.com/api/v3/questions/1/answers?page=1",
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
                "url": "https://{environment}.synega.com/api/v3/questions/1/answers?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next",
                "active": false
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/questions/1/answers",
        "per_page": 10,
        "to": 2,
        "total": 2
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a question answer in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/questions/{question_id}/answers`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question which the answer should answer to.
answer | string | **Yes** | The content of the question answer.
user_id | string | **Yes** | The user ID of the question answer author.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/answers \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "answer": "Definitely yes!",
        "user_id": 3
    }'
```

### Example Response

```json
{
    "data": {
        "id": 3,
        "answer": "Definitely yes!",
        "created_at": "2020-10-16 14:12:04",
        "user": {
            "id": 1,
            "active": true,
            "name": "John Doe",
            "email": "john.doe@synega.com",
            "phone": 4712341234,
            "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>",
            "profile_picture_url": "url-to-profile"
        }
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific question answer.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question which the answer was given to.
answer_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question answer.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 3,
        "answer": "Definitely yes!",
        "created_at": "2020-10-16 14:12:04",
        "user": {
            "id": 1,
            "active": true,
            "name": "John Doe",
            "email": "john.doe@synega.com",
            "phone": 4712341234,
            "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>",
            "profile_picture_url": "url-to-profile"
        }
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a question answer.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question which the answer was given to.
answer_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question answer.
answer | string | No | The content of the question answer.
user_id | string | No | The user ID of the question answer author.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "user_id": "1"
    }'
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "answer": "Definitely yes!",
        "created_at": "2020-10-16 14:12:04",
        "user": {
            "id": 1,
            "active": true,
            "name": "John Doe",
            "email": "john.doe@synega.com",
            "phone": 4712341234,
            "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>",
            "profile_picture_url": "url-to-profile"
        }
    }
}
```

<a name="delete"></a>
## Delete

This endpoint deleted a specific question answer.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question which the answer was given to.
answer_id <small>(url param)</small> | integer | **Yes** | The unique ID of the question answer.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/questions/{question_id}/answers/{answer_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```


