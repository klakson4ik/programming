package com.klakson4ik;

public class SocialFollowersFactory {
    public static void main(){
        String prop = Props.getProp("social-followers");
        String[] line = prop.split(",");
        for(String word : line){
            try{
                IFollowersFactory factory = choiceFactory(word);
            factory.create();
            } catch(NullPointerException e){
                System.out.println("No socialFollowers");
            }
        }
    }

    private static IFollowersFactory choiceFactory(String factory){
        switch(factory){
            case "facebook":
                return new FacebookFollowersFactory();
            case "facebook-dev":
                return new FacebookFollowersDevFactory();
            case "":
                return null; 
            default:
                throw new RuntimeException("doesn`t exists " + factory + " factory");
        }
    }
}

interface IFollowersFactory{
    void  create();
}

interface IFacebookFollowersFactory extends IFollowersFactory{
    void create();
}

class FacebookFollowersFactory implements IFacebookFollowersFactory{
    public void create(){
        new FacebookFollowers();
    }
}

class FacebookFollowersDevFactory implements IFacebookFollowersFactory{
    public void create(){
        new FacebookFollowersDev();
    }
}



