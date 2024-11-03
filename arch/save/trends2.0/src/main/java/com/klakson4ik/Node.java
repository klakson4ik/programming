package com.klakson4ik;

import java.util.List;
import java.util.ArrayList;

public class Node {
    private String ID;
    private String rank;
    private String url;
    private String title;
    private String description;
    private String text = "";
    private String keywords = "";
    private List<String> images;
    private List<String> imagesAlt;
    private List<String> imagesFull;

    public void getStringNode(){
        System.out.println( "rank: " + rank); 
        System.out.println("url: " + url);
        System.out.println("title: " + title);
        System.out.println("description: " + description);
        // System.out.println("keywords: " + keywords);
        // System.out.println("images: " + images);
        // System.out.println("imagesAlt: " + imagesAlt);
        System.out.println("text:");
        System.out.println("=================================");
        System.out.println(text); 
        System.out.println("================================= end Node ====>");
    }

    public void fillNode(String rank, String url, String title, List<String> keywords){
        this.rank = rank;
        this.url = url;
        this.title = title;
        keywordsToString(keywords);
    }

    public void keywordsToString(List<String> keywords){
        String tmpKeywords = "";
        for (String keyword : keywords){
            if(tmpKeywords.isEmpty()){
                tmpKeywords = keyword;
            }else{
                tmpKeywords += ", " + keyword;
            }
        }
        if(this.keywords.isEmpty()){
            this.keywords = tmpKeywords;
        }else{  
            this.keywords += ", " + tmpKeywords;
        }
    }
    

    public Node getNode(){
        return this;
    }

    public String getID(){
        return ID;
    }

    public void setID(String ID){
        this.ID = ID;
    }

    public String getRank(){
        return rank;
    }

    public String getUrl(){
        return url;
    }

    public String getTitle(){
        return title;
    }

    public String getKeywords(){
        return keywords;
    }

    public String getText(){
        return text;
    }

    public void setText(String text){
        this.text = text;
    }

    public String getDescription(){
        return description;
    }

    public void setDescription(String description){
        this.description = description;
    }

    public List<String> getImages(){
        return images;
    }

    public void setImages(List<String> images){
        this.images = new ArrayList<String>(images);
    }

    public List<String> getImagesFull(){
        return imagesFull;
    }

    public void setImagesFull(List<String> imagesFull){
        this.imagesFull = new ArrayList<String>(imagesFull);
    }

    public List<String> getImagesAlt(){
        return imagesAlt;
    }

    public void setImagesAlt(List<String> imagesAlt){
        this.imagesAlt = new ArrayList<String>(imagesAlt);
    }
}
