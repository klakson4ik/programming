package com.klakson4ik;

public class SocialShareFactory {
    public static void main(){
        String prop = Props.getProp("social-share");
        String[] line = prop.split(",");
        for(String word : line){
            try{
                IShareFactory factory = choiceFactory(word);
                factory.create();
            } catch(NullPointerException e){
                System.out.println("No socialShare");
            }
        }
    }

    private static IShareFactory choiceFactory(String factory){
        switch(factory){
            case "facebook":
                return new FacebookShareFactory();
            case "facebook-dev":
                return new FacebookShareDevFactory();
            case "twitter":
                return new TwitterShareFactory();
            case "twitter-dev":
                return new TwitterShareDevFactory();
            case "tumblr":
                return new TumblrShareFactory();
            case "tumblr-dev":
                return new TumblrShareDevFactory();
            case "livejournal":
                return new LivejournalShareFactory();
            case "livejournal-dev":
                return new LivejournalShareDevFactory();
            case "":
                return null;
            default:
                throw new RuntimeException("doesn`t exists " + factory + " factory");
        }
    }
}

interface IShareFactory{
    void  create();
}

interface IFacebookShareFactory extends IShareFactory{
    void create();
}

interface ITwitterShareFactory extends IShareFactory{
    void create();
}

interface ITumblrShareFactory extends IShareFactory{
    void create();
}

interface ILivejournalShareFactory extends IShareFactory{
    void create();
}

class FacebookShareFactory implements IFacebookShareFactory{
    public void create(){
        new FacebookShare();
    }
}

class FacebookShareDevFactory implements IFacebookShareFactory{
    public void create(){
        new FacebookShareDev();
    }
}

class TwitterShareFactory implements ITwitterShareFactory{
    public void create(){
        new TwitterShare();
    }
}

class TwitterShareDevFactory implements ITwitterShareFactory{
    public void create(){
        new TwitterShareDev();
    }
}

class TumblrShareFactory implements ITumblrShareFactory{
    public void create(){
        new TumblrShare();
    }
}

class TumblrShareDevFactory implements ITumblrShareFactory{
    public void create(){
        new TumblrShareDev();
    }
}

class LivejournalShareFactory implements ILivejournalShareFactory{
    public void create(){
        new LivejournalShare();
    }
}

class LivejournalShareDevFactory implements ILivejournalShareFactory{
    public void create(){
        new LivejournalShareDev();
    }
}
