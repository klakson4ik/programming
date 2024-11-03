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

    public static void storeDB(RealtimeNode node) {
        try (Connection connection = new DBConnector().getDBConnection()){
            String query = "SELECT title FROM articles WHERE title = ?";
            PreparedStatement stmt = connection.prepareStatement(query);
            stmt.setString(1, node.getTitle());
            ResultSet resultSet = stmt.executeQuery();
            if(resultSet.next()){
                System.out.println("Data " + node.getTitle() + " exists in database");
                // trendsData.remove(node);
                return;
            }
            query = "INSERT INTO articles(title, keywords, description, url) " +
                            "VALUES (?, ?, ?, ?)"; 
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setString(1, node.getTitle());
            statement.setString(2, node.getKeywords());
            statement.setString(3, node.getDescription());
            statement.setString(4, node.getUrl());
            statement.executeUpdate();
            count++;
            System.out.println("Data " + node.getTitle() + " add");
            query = "SELECT id FROM articles WHERE title = ?";
            stmt = connection.prepareStatement(query);
            stmt.setString(1, node.getTitle());
            resultSet = stmt.executeQuery();
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

    public static void storeImagesDB(RealtimeNode node) {
        try (Connection connection = new DBConnector().getDBConnection()){
            List<String> images = new ArrayList<String>(node.getImages());
            List<String> imagesAlt = new ArrayList<String>(node.getImagesAlt());
            List<String> imagesFull = new ArrayList<String>(node.getImagesFull());
            // System.out.println("ALT++++++++++++++++> " + imagesAlt);
            for(int i = 0; i < images.size(); ++i){
                String query = "INSERT INTO images (articles_id, image, image_alt, image_full) " +
                                "VALUES (?, ?, ?, ?)"; 
                PreparedStatement statement = connection.prepareStatement(query);
                System.out.println("\u001B[31m" + imagesAlt.get(i) + "\u001B[0m");
                statement.setString(1, node.getID());
                statement.setString(2, images.get(i));
                statement.setString(3, imagesAlt.get(i));
                statement.setString(4, imagesFull.get(i));
                statement.executeUpdate();
            }
            // System.out.println("Images " + node.getTitle() + " add " + node.getID());
        }catch(SQLException e){
            // e.printStackTrace();
        }

    }

    public static void storeDescriptionDB(RealtimeNode node) {
        try (Connection connection = new DBConnector().getDBConnection()){
            // System.out.println("SQL prepare");
            String query = "UPDATE articles SET description = ?, text = ? " +
                            "WHERE id = ?"; 
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setString(1, node.getDescription());
            statement.setString(2, node.getText());
            statement.setString(3, node.getID());
            statement.executeUpdate();
            System.out.println("Description " + node.getTitle() + " add " + node.getID());
        }catch(SQLException e){
            // e.printStackTrace();
        }

    }

    public static byte getCount(){
        return count;
    }
}
