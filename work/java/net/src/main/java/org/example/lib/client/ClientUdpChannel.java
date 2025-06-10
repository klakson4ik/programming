package org.example.lib.client;

import org.example.lib.server.Server;

import java.io.IOException;
import java.net.*;

public class ClientUdpChannel {
    private final DatagramSocket socket;
    private final InetAddress address;

    private final int port;

    public ClientUdpChannel(String hostname, int port) {
        try {
            address = InetAddress.getByName(hostname);
            socket = new DatagramSocket();
        } catch (UnknownHostException | SocketException e) {
            throw new RuntimeException(e);
        }
        this.port = port;
    }

    public void start(){
        while (true) {

        }
    }

    public void send(String msg) {
        byte[] buffer = msg.getBytes();
        DatagramPacket packet
                = new DatagramPacket(buffer, buffer.length, address, port);
        try {
            socket.send(packet);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        byte[] responceBuffer = new byte[65503];
        packet = new DatagramPacket(responceBuffer, responceBuffer.length);
        try {
            socket.receive(packet);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        String received = new String(
                packet.getData(), 0, packet.getLength());
        System.out.println("Сообщение от Сервера: " + received);
    }
}
