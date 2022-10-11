# Tickets

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Reply](#reply)
- [Mark as solved](#markAsSolved)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the ticket object.
user_id | integer | The assignee user ID of the ticket.
requester_id | integer | The requester ID of the ticket.
category_id | integer | The category ID of the ticket.
service_id | integer | The service ID of the ticket.
country_id | integer | The country ID of the ticket.
title | string | The title of the ticket.
status | string | The status of the ticket.
due_at | datetime | The due date of the ticket.
created_at | datetime | The date of the ticket creation.
updated_at | datetime | The date of the ticket last update.

<a name="index"></a>
## Index

This endpoint indexes all tickets in Connect.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/tickets`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page | integer | No | Which page of the paginated response we should return.
title | string | No | Search for a specific title.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/tickets?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 26,
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "requester": {
        "id": 5,
        "synega_id": 325,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "Johnny",
        "last_name": "Dowson",
        "username": "johnny.dowson",
        "email": "johnny_dowson@example.com",
        "phone_number": 47833553145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "category": {
        "id": 8,
        "name": "Category 1-2",
        "parent": {
          "id": 7,
          "name": "Category 1",
          "parent": null,
          "user": {
            "id": 6,
            "synega_id": 327,
            "onelogin_id": null,
            "duo_id": null,
            "active": true,
            "first_name": "John",
            "last_name": "Doe",
            "username": "john.doe",
            "email": "john_doe@example.com",
            "phone_number": 47833333145,
            "role": 30,
            "slack_webhook_url": null,
            "blog_notifications": true
          },
          "sla_hours": 12
        },
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 3
      },
      "service": {
        "id": 3,
        "identifier": "SR",
        "name": "Service2"
      },
      "country": {
        "id": 3,
        "identifier": "NO",
        "name": "Norway"
      },
      "title": "Title of ticket",
      "due_at": "2021-02-15 11:00:00",
      "status": "open"
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v1/tickets?page=1",
    "last": "https://{environment}.synega.com/api/v1/tickets?page=2",
    "prev": null,
    "next": "https://{environment}.synega.com/api/v1/tickets?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "links": [
      {
        "url": null,
        "label": "&laquo; Forrige",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/tickets?page=1",
        "label": 1,
        "active": true
      },
      {
        "url": "https://{environment}.synega.com/api/v1/tickets?page=2",
        "label": 2,
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/tickets?page=2",
        "label": "Neste &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v1/tickets",
    "per_page": 10,
    "to": 10,
    "total": 19
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a ticket in Connect.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/tickets`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id | integer | No | The assignee user ID of the ticket.
comment_user_id | integer | **Yes** | The first comment author ID of the ticket.
comment | text | **Yes** | The content of the first comment of the ticket.
title | string | **Yes** | The title of the ticket.
requester_id | integer | **Yes** | The requester ID of the ticket.
category_id | integer | **Yes** | The category ID of the ticket.
subcategory_id | integer | No | The subcategory ID of the ticket.
service_id | integer | **Yes** | The service ID of the ticket.
country_id | integer | **Yes** | The country ID of the ticket.
due_at | datetime | No | The due date of the ticket.
status | string | No | The status of the ticket.
attachments | array | No | The array of attachments for the first ticket comment.
attachments.* | file | No | The attachment for the first ticket comment.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/tickets \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "category_id": 8,
        "service_id": 3, 
        "country_id": 3, 
        "title": "Title of the ticket", 
        "comment": "This is the first ticket", 
        "requester_id": 5,
        "comment_user_id": 2,
    }'
```

### Example Response

```json
{
  "data": {
    "id": 26,
    "user": {
      "id": 6,
      "synega_id": 327,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "john.doe",
      "email": "john_doe@example.com",
      "phone_number": 47833333145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "requester": {
      "id": 5,
      "synega_id": 325,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "Johnny",
      "last_name": "Dowson",
      "username": "johnny.dowson",
      "email": "johnny_dowson@example.com",
      "phone_number": 47833553145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "category": {
      "id": 8,
      "name": "Category 1-2",
      "parent": {
        "id": 7,
        "name": "Category 1",
        "parent": null,
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 12
      },
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "sla_hours": 3
    },
    "service": {
      "id": 3,
      "identifier": "SR",
      "name": "Service2"
    },
    "country": {
      "id": 3,
      "identifier": "NO",
      "name": "Norway"
    },
    "title": "Title of ticket",
    "due_at": "2021-02-15 11:00:00",
    "status": "open"
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific ticket in Connect.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/tickets/{ticket_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
ticket_id <small>(url param)</small> | integer | **Yes** | The unique ID of the ticket.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/tickets/{ticket_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 26,
    "user": {
      "id": 6,
      "synega_id": 327,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "john.doe",
      "email": "john_doe@example.com",
      "phone_number": 47833333145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "requester": {
      "id": 5,
      "synega_id": 325,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "Johnny",
      "last_name": "Dowson",
      "username": "johnny.dowson",
      "email": "johnny_dowson@example.com",
      "phone_number": 47833553145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "category": {
      "id": 8,
      "name": "Category 1-2",
      "parent": {
        "id": 7,
        "name": "Category 1",
        "parent": null,
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 12
      },
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "sla_hours": 3
    },
    "service": {
      "id": 3,
      "identifier": "SR",
      "name": "Service2"
    },
    "country": {
      "id": 3,
      "identifier": "NO",
      "name": "Norway"
    },
    "title": "Title of ticket",
    "due_at": "2021-02-15 11:00:00",
    "status": "open"
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific ticket in Connect.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v1/tickets/{ticket_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
ticket_id <small>(url param)</small> | integer | **Yes** | The unique ID of the ticket.
title | string | No | The title of the ticket.
user_id | integer | No | The assignee user ID of the ticket.
requester_id | integer | No | The requester ID of the ticket.
category_id | integer | No | The category ID of the ticket.
subcategory_id | integer | No | The subcategory ID of the ticket.
service_id | integer | No | The service ID of the ticket.
country_id | integer | No | The country ID of the ticket.
due_at | datetime | No | The due date of the ticket.
status | string | No | The status of the ticket.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v1/tickets/{ticket_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "subcategory_id": 12,
        "title": "Title of ticket (updated recently)"  
    }'
```

### Example Response

```json
{
  "data": {
    "id": 26,
    "user": {
      "id": 6,
      "synega_id": 327,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "john.doe",
      "email": "john_doe@example.com",
      "phone_number": 47833333145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "requester": {
      "id": 5,
      "synega_id": 325,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "Johnny",
      "last_name": "Dowson",
      "username": "johnny.dowson",
      "email": "johnny_dowson@example.com",
      "phone_number": 47833553145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "category": {
      "id": 2,
      "name": "Category 2",
      "parent": {
        "id": 7,
        "name": "Category 1",
        "parent": null,
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 12
      },
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "sla_hours": 3
    },
    "service": {
      "id": 3,
      "identifier": "SR",
      "name": "Service2"
    },
    "country": {
      "id": 3,
      "identifier": "NO",
      "name": "Norway"
    },
    "title": "Title of ticket (updated recently)",
    "due_at": "2021-02-15 11:00:00",
    "status": "open"
  }
}
```

<a name="reply"></a>
## Reply

This endpoint replies to a specific ticket in Connect.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/tickets/{ticket_id}/reply`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
ticket_id <small>(url param)</small> | integer | **Yes** | The unique ID of the ticket.
user_id | integer | **Yes** | The comment author ID.
content | text | **Yes** | The content of the comment.
private | boolean | **Yes** | Determines if the comment private or public.
attachments | array | No | The array of attachments for the comment.
attachments.* | file | No | The attachment for the comment.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/tickets/{ticket_id}/reply \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "user_id": 3,
        "content": "Please, see the attachment from my previous comment.",
        "private": false  
    }'
```

### Example Response

```json
{
  "data": {
    "id": 53,
    "ticket": {
      "id": 26,
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "requester": {
        "id": 5,
        "synega_id": 325,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "Johnny",
        "last_name": "Dowson",
        "username": "johnny.dowson",
        "email": "johnny_dowson@example.com",
        "phone_number": 47833553145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "category": {
        "id": 2,
        "name": "Category 2",
        "parent": {
          "id": 7,
          "name": "Category 1",
          "parent": null,
          "user": {
            "id": 6,
            "synega_id": 327,
            "onelogin_id": null,
            "duo_id": null,
            "active": true,
            "first_name": "John",
            "last_name": "Doe",
            "username": "john.doe",
            "email": "john_doe@example.com",
            "phone_number": 47833333145,
            "role": 30,
            "slack_webhook_url": null,
            "blog_notifications": true
          },
          "sla_hours": 12
        },
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 3
      },
      "service": {
        "id": 3,
        "identifier": "SR",
        "name": "Service2"
      },
      "country": {
        "id": 3,
        "identifier": "NO",
        "name": "Norway"
      },
      "title": "Title of ticket (updated recently)",
      "due_at": "2021-02-15 11:00:00",
      "status": "open"
    },
    "user": {
      "id": 6,
      "synega_id": 327,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "john.doe",
      "email": "john_doe@example.com",
      "phone_number": 47833333145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "private": false,
    "content": "Please, see the attachment from my previous comment.",
    "created_at": "2021-02-14 12:53:34"
  }
}
```

<a name="markAsSolved"></a>
## Mark as solved

This endpoint marks a specific ticket in Connect as solved.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/tickets/{ticket_id}/mark-as-solved`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
ticket_id <small>(url param)</small> | integer | **Yes** | The unique ID of the ticket.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/tickets/{ticket_id}/mark-as-solved \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 26,
    "user": {
      "id": 6,
      "synega_id": 327,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "john.doe",
      "email": "john_doe@example.com",
      "phone_number": 47833333145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "requester": {
      "id": 5,
      "synega_id": 325,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "Johnny",
      "last_name": "Dowson",
      "username": "johnny.dowson",
      "email": "johnny_dowson@example.com",
      "phone_number": 47833553145,
      "role": 30,
      "slack_webhook_url": null,
      "blog_notifications": true
    },
    "category": {
      "id": 2,
      "name": "Category 2",
      "parent": {
        "id": 7,
        "name": "Category 1",
        "parent": null,
        "user": {
          "id": 6,
          "synega_id": 327,
          "onelogin_id": null,
          "duo_id": null,
          "active": true,
          "first_name": "John",
          "last_name": "Doe",
          "username": "john.doe",
          "email": "john_doe@example.com",
          "phone_number": 47833333145,
          "role": 30,
          "slack_webhook_url": null,
          "blog_notifications": true
        },
        "sla_hours": 12
      },
      "user": {
        "id": 6,
        "synega_id": 327,
        "onelogin_id": null,
        "duo_id": null,
        "active": true,
        "first_name": "John",
        "last_name": "Doe",
        "username": "john.doe",
        "email": "john_doe@example.com",
        "phone_number": 47833333145,
        "role": 30,
        "slack_webhook_url": null,
        "blog_notifications": true
      },
      "sla_hours": 3
    },
    "service": {
      "id": 3,
      "identifier": "SR",
      "name": "Service2"
    },
    "country": {
      "id": 3,
      "identifier": "NO",
      "name": "Norway"
    },
    "title": "Title of ticket (updated recently)",
    "due_at": "2021-02-15 11:00:00",
    "status": "solved"
  }
}
```
