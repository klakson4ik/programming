package org.example.lib.server;

public abstract class Server extends Thread {
    protected final byte[] buffer = new byte[65503];
    protected int port;
    public abstract void run();
}
