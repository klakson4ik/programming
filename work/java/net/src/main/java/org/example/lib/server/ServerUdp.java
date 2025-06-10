package org.example.lib.server;

import java.io.IOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.SocketException;

public class ServerUdp extends Server {
    private final DatagramSocket socket;

    public ServerUdp(int port) {
        this.port = port;
        try {
            socket = new DatagramSocket(port);
        } catch (SocketException e) {
            throw new RuntimeException(e);
        }
    }

    public void run(){
        boolean running = true;
        while (running){
            DatagramPacket packet = new DatagramPacket(buffer, buffer.length);
            try {
                socket.receive(packet);
            } catch (IOException e) {
                throw new RuntimeException(e);
            }
            String received = new String(packet.getData(), 0, packet.getLength());
            if(received.equals("end")){
                running = false;
            }
            System.out.println(received);
            String responeMsg = "Пакет успешно пришел на сервер";
            byte[] responceBuffer = responeMsg.getBytes();
            packet = new DatagramPacket(responceBuffer, responceBuffer.length, packet.getAddress(), packet.getPort());
            try {
                socket.send(packet);
            } catch (IOException e) {
                throw new RuntimeException(e);
            }
        }
        socket.close();
    }
}
