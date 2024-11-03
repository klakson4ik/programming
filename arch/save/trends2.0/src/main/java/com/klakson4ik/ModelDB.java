package com.klakson4ik;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.PreparedStatement;
import java.sql.Statement;
import java.sql.ResultSet;
import java.util.List;
import java.util.ArrayList;

public class ModelDB {
    private static byte count = 0;

    public static void storeDB(Node node) {
        try (Connection connection = new DBConnector().getDBConnection()){
            String query = "INSERT INTO articles(title, keywords, description, url, text, date_create) " +
                            "VALUES (?, ?, ?, ?, ?, NOW())"; 
            PreparedStatement stmt = connection.prepareStatement(query);
            stmt.setString(1, node.getTitle());
            stmt.setString(2, node.getKeywords());
            stmt.setString(3, node.getDescription());
            stmt.setString(4, node.getUrl());
            stmt.setString(5, node.getText());
            stmt.executeUpdate();
            count++;
            System.out.println("Data " + node.getTitle() + " add");
            query = "SELECT id FROM articles WHERE title = ?";
            stmt = connection.prepareStatement(query);
            stmt.setString(1, node.getTitle());
            ResultSet resultSet = stmt.executeQuery();
            resultSet.next();
            String ID = resultSet.getString(1);
            node.setID(ID);
            // System.out.println("getting " + node.getID() + " for " + node.getTitle());
        }catch(SQLException e){
            // trendsData.remove(node);
            // node.getStringNode();
            e.printStackTrace();
        }

    }

    public static void storeImagesDB(Node node) {
        try (Connection connection = new DBConnector().getDBConnection()){
            List<String> images = new ArrayList<String>(node.getImages());
            List<String> imagesAlt = new ArrayList<String>(node.getImagesAlt());
            List<String> imagesFull = new ArrayList<String>(node.getImagesFull());
                System.out.println(images.size());
                System.out.println(imagesAlt.size());
                System.out.println(imagesFull.size());
            // System.out.println("ALT++++++++++++++++> " + imagesAlt);
            for(int i = 0; i < images.size(); ++i){
                String query = "INSERT INTO images (articles_id, image, image_alt, image_full) " +
                                "VALUES (?, ?, ?, ?)"; 
                PreparedStatement statement = connection.prepareStatement(query);
                System.out.println("\u001B[31m" + imagesAlt.get(i) + "\u001B[0m");
                statement.setString(1, node.getID());
                statement.setString(2, images.get(i));
                statement.setString(3, imagesAlt.get(i));
                System.out.println(imagesFull.get(i));
                statement.setString(4, imagesFull.get(i));
                statement.executeUpdate();
            }
            // System.out.println("Images " + node.getTitle() + " add " + node.getID());
        }catch(SQLException e){
            // e.printStackTrace();
        }
    }

    public static void checkInDB(){
        List<Node> nodesRemove = new ArrayList<Node>();
        System.out.println(TrendsData.getList().size());
        try (Connection connection = new DBConnector().getDBConnection()){
            for(Node node : TrendsData.getList()){
                String query = "SELECT title FROM articles WHERE title = ?";
                PreparedStatement stmt = connection.prepareStatement(query);
                stmt.setString(1, node.getTitle());
                ResultSet resultSet = stmt.executeQuery();
                if(resultSet.next()){
                    System.out.println("Data " + node.getTitle() + " exists in database");
                    nodesRemove.add(node);
                }
            } 
            for(Node nodeRemove : nodesRemove){
                TrendsData.removeNode(nodeRemove);
            }
            System.out.println(TrendsData.getList().size());
        }catch(SQLException e){
            // e.printStackTrace();
        }
    }

    public static byte getCount(){
        return count;
    }
}
