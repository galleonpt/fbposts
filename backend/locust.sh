docker rm locusttestes -f &&
docker image rm locusttestes &&
docker build . -t locusttestes &&
docker run -p 80:80 --network FBNetwork -d --name locusttestes locusttestes