const int initServer(struct sockaddr_in *address, const char *argv[]);
void startConnect(struct sockaddr_in address, const int serverFd);
void closeConnect(const int serverFd);
