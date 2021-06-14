import time
from locust import HttpUser, task, between

class ApiUser(HttpUser):
  def __init__(self, parent):
    super(ApiUser, self).__init__(parent)
    self.token = ""

  wait_time=between(1,5)
  
  def on_start(self):
    response = self.client.post(
      url="/authenticate/login", 
      json={
        "username":"admin", 
        "password":"admin"
      })
    self.token = "Bearer " + response.json()["token"]    

  @task
  def CreatePost(self):
    response=self.client.post(url="/private/posts", json={"internalPageId":1, "message":"locust", "sendTime":1710255676}, headers={"authorization":self.token})

  @task
  def ListUserPosts(self):
    response=self.client.get(url="/private/posts", headers={"authorization":self.token})
    for i in range(2, response.json()['last_page']):
      self.client.get(url="/private/posts?page="+str(i), headers={"authorization":self.token})
    