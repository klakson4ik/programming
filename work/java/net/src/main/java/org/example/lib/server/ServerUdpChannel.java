package org.example.lib.server;

import java.io.IOException;
import java.net.DatagramPacket;
import java.net.InetSocketAddress;
import java.net.SocketAddress;
import java.nio.ByteBuffer;
import java.nio.channels.DatagramChannel;
import java.nio.charset.StandardCharsets;

public class ServerUdpChannel extends Server {
    private final DatagramChannel socket;

    private final ByteBuffer buffer = ByteBuffer.allocate(65503);

    public ServerUdpChannel(int port) {
        this.port = port;
        try {
            socket = DatagramChannel.open();
            socket.configureBlocking(false);
            socket.bind(new InetSocketAddress(port));
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }

    public void run(){
        boolean running = true;
        while (running){
            buffer.clear();
            try {
                SocketAddress clientAddress = socket.receive(buffer);
                if(clientAddress != null){
                    buffer.flip();
                    byte[] bytes = new byte[buffer.remaining()];
                    buffer.get(bytes);
                    System.out.println(new String(bytes, StandardCharsets.UTF_8));
                    String responseMsg = "Пакет успешно пришел на сервер";
                    try {
                        socket.send(ByteBuffer.wrap(responseMsg.getBytes(StandardCharsets.UTF_8)), clientAddress);
                    } catch (IOException e) {
                        throw new RuntimeException(e);
                    }
                }
            } catch (IOException e) {
                throw new RuntimeException(e);
            }

        }
        try {
            socket.close();
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}
