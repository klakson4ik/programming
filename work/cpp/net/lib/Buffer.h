//
// Created by kudryavtsev on 20.02.25.
//

#ifndef NET_BUFFER_H
#define NET_BUFFER_H


class Buffer {
public:
    Buffer();
    virtual ~Buffer();

public:
    char *getMsg() const;

    void setMsg(char *msg);

    unsigned int getLength() const;

    void setLength(unsigned int length);

private:
    char *msg;
    unsigned int length;
};


#endif //NET_BUFFER_H
