This is the repository of the REST API of _Chipper_, a fictional microblogging application. It has the following features:

### Registration
- A guest can register

### Authentication
- A user can login with email and password
- A users can not authenticate with an invalid password
- A user can get his session
- A guest can not get his session
- A user can logout

### Favorite
- A guest can not favorite a post
- A user can favorite a post
- A user can remove a post from his favorites
- A user can not remove a non favorited item

### Post
- A guest can not create a post
- A user can create a post
- A user can update a post
- A user can not update a post by other user
- A user can destroy one of his posts


### VERSION 1.1
## 1. Add the ability for users to favorite users
## 2. Update the payload of `GET /favorites` to list posts and users
```
{
  "data": {
    "posts": [
      {
        "id": 1,
        "title": "All about cats",
        "body": "Lorem Ipsum...",
        "user": { "id": 5, "name": "Jack" }
      },
      {
        "id": 1,
        "title": "All about dogs",
        "body": "Lorem Ipsum...",
        "user": { "id": 1, "name": "Zara" }
      }
    ],
    "users": [
      { "id": 5, "name": "Jack" },
      { "id": 8, "name": "Jane" },
      { "id": 9, "name": "Luke" }
    ]
  }
}
```

## 3. Notify a user whenever one of their favored users creates a new post.

The users of Chipper want to stay up to date with the people they are following.

Every time a user creates a new post, the system should notify via email to all the users who have them in their list of favorites. The goal of this task is to code that feature.

## 4. Import users
The command should receive two parameters: URL of the JSON and limit number of users to import.

The JSON file will always follow this structure: https://jsonplaceholder.typicode.com/users. Please use this URL during your development.
