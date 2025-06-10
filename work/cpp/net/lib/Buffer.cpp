//
// Created by kudryavtsev on 20.02.25.
//

#include "Buffer.h"

Buffer::Buffer(){
    msg = new char;
}

Buffer::~Buffer() {
    delete msg;
}

char *Buffer::getMsg() const {
    return msg;
}

void Buffer::setMsg(char *msg) {
    Buffer::msg = msg;
}

unsigned int Buffer::getLength() const {
    return length;
}

void Buffer::setLength(unsigned int length) {
    Buffer::length = length;
}
