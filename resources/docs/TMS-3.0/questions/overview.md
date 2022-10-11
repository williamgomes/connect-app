# Questions

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the question object.
question_user_id | integer | The ID of the user who asked a question.
question_answer_id | integer | The primary answer of a question.
question_category_id | integer | The category of a question.
title | string | The title of a question.
question | string | The actual question content of a question.
visible | boolean | Determines if a question is visible or not.

<a name="index"></a>
## Index

This endpoint indexes all questions in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/questions`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
search | string | No | Search with title or question content.
category_id | integer | No | The unique ID of the question category.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/questions?category_id=1&page=1 \
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
            "visible": true,
            "title": "Our planet title",
            "question": "How is our planet called?",
            "user": {
                "id": 1,
                "name": "Yester Nath",
                "email": "yester@example.com",
                "phone": 41551452421
            },
            "category": {
                "id": 1,
                "title": "Cosmos"
            },
            "primary_answer": {
                "id": 1,
                "answer": "Earth",
                "created_at": "2020-10-13 15:53:23",
                "user": {
                    "id": 1,
                    "active": true,
                    "role": 10,
                    "name": "Jeff Maiser",
                    "email": "jeff@example.com",
                    "phone": 37477866780,
                    "profile_picture": "IFWeeej6wPATUpvlo9GM9RazolGOwgitYoXW4hp9.jpeg",
                    "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>"
                }
            },
            "answers": [
                {
                    "id": 1,
                    "answer": "Earth",
                    "created_at": "2020-10-13 15:53:23",
                    "user": {
                        "id": 1,
                        "active": true,
                        "role": 10,
                        "name": "Jeff Maiser",
                        "email": "jeff@example.com",
                        "phone": 37477866780,
                        "profile_picture": "IFWeeej6wPATUpvlo9GM9RazolGOwgitYoXW4hp9.jpeg",
                        "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>"
                    }
                },
                {
                    "id": 2,
                    "answer": "Pluto maybe",
                    "created_at": "2020-10-13 16:13:16",
                    "user": {
                        "id": 3,
                        "active": true,
                        "role": 20,
                        "name": "Jill Hanks",
                        "email": "jill@example.com",
                        "phone": 47909344911,
                        "profile_picture": "DMNt0Xjgggg5Ql1UlC81ZBFqJZzmaBjwk8ZLM.jpeg",
                        "about": ""
                    }
                }
            ]
        }
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/questions?page=1",
        "last": "https://{environment}.synega.com/api/v3/questions?page=1",
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
                "url": "https://{environment}.synega.com/api/v3/questions?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next",
                "active": false
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/questions",
        "per_page": 25,
        "to": 1,
        "total": 1
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a question in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/questions`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_user_id | integer | **Yes** | The ID of the user who asked a question.
question_answer_id | integer | No | The primary answer of a question.
question_category_id | integer | **Yes** | The category of a question.
title | string | **Yes** | The title of a question.
question | string | **Yes** | The actual question content of a question.
visible | boolean | **Yes** | Determines if a question is visible or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/questions \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "title": "New Client creation",
       "question": "How to create a new client?",
       "question_category_id": 3,
       "question_user_id": 1,
       "visible": true
    }'
```

### Example Response

```json
{
    "data": {
        "id": 6,
        "visible": true,
        "title": "New client creation",
        "question": "How to create a new client?",
        "user": {
            "id": 1,
            "name": "Andy Nath",
            "email": "andy@example.com",
            "phone": 41551452421
        },
        "category": {
            "id": 3,
            "title": "Common questions"
        },
        "primary_answer": null,
        "answers": []
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific question.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/questions/{question_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/questions/{question_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "visible": true,
        "title": "Our planet title",
        "question": "How is our planet called?",
        "user": {
            "id": 1,
            "name": "Yester Nath",
            "email": "yester@example.com",
            "phone": 41551452421
        },
        "category": {
            "id": 1,
            "title": "Cosmos"
        },
        "primary_answer": {
            "id": 1,
            "answer": "Earth",
            "created_at": "2020-10-13 15:53:23",
            "user": {
                "id": 1,
                "active": true,
                "role": 10,
                "name": "Jeff Maiser",
                "email": "jeff@example.com",
                "phone": 37477866780,
                "profile_picture": "IFWeeej6wPATUpvlo9GM9RazolGOwgitYoXW4hp9.jpeg",
                "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>"
            }
        },
        "answers": [
            {
                "id": 1,
                "answer": "Earth",
                "created_at": "2020-10-13 15:53:23",
                "user": {
                    "id": 1,
                    "active": true,
                    "role": 10,
                    "name": "Jeff Maiser",
                    "email": "jeff@example.com",
                    "phone": 37477866780,
                    "profile_picture": "IFWeeej6wPATUpvlo9GM9RazolGOwgitYoXW4hp9.jpeg",
                    "about": "<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum.</p>"
                }
            },
            {
                "id": 2,
                "answer": "Pluto maybe",
                "created_at": "2020-10-13 16:13:16",
                "user": {
                    "id": 3,
                    "active": true,
                    "role": 20,
                    "name": "Jill Hanks",
                    "email": "jill@example.com",
                    "phone": 47909344911,
                    "profile_picture": "DMNt0Xjgggg5Ql1UlC81ZBFqJZzmaBjwk8ZLM.jpeg",
                    "about": ""
                }
            }
        ]
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a question.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/questions/{question_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question.
question_answer_id | integer | No | The primary answer of a question.
visible | boolean | No | Determines if a question is visible or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/questions/{question_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "question_answer_id": 1
    }'
```

### Example Response

```json
{
    "data": {
        "id": 6,
        "visible": true,
        "title": "New Client creation",
        "question": "How to create a new client?",
        "user": {
            "id": 1,
            "name": "Yester Nath",
            "email": "y@nat.com",
            "phone": 41551452421
        },
        "category": {
            "id": 3,
            "title": "UI questions"
        },
        "primary_answer": {
            "id": 1,
            "answer": "Easy, here is the link",
            "created_at": "2020-10-13 15:53:23",
            "user": {
                "id": 3,
                "active": true,
                "role": 20,
                "name": "Jill Hanks",
                "email": "jill@example.com",
                "phone": 47909344911,
                "profile_picture": "DMNt0Xjgggg5Ql1UlC81ZBFqJZzmaBjwk8ZLM.jpeg",
                "about": ""
            }
        },
        "answers": []
    }
}
```

<a name="delete"></a>
## Delete

This endpoint deleted a specific question.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/questions/{question_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
question_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the question.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/questions/{question_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```
