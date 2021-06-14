db.createUser({
  user: "root",
  pwd: "secret",
  roles: [{
      role: "dbAdmin",
      db: "desafio2"
    },
    {
      role: "readWrite",
      db: "desafio2"
    }
  ]
});
db.getSiblingDB('desafio2');