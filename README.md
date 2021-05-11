# Pre-install
```bash
sudo apt-get install git docker docker-compose
```

# Install
1 Clone the project.
```bash
git clone ...
```
2 Set the environments
```bash
make copy-env
```
3 Initialize the application.
```bash
make init
```

After these steps, the site should be accessible at the address stored in the env variable APP_URL.