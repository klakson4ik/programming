package com.klakson4ik;

import java.util.List;

public class App {
    public final static void main(String[] args){
        Content content = new Content();
        content.start();
        SiteMap.start();
        SocialShareFactory.main();
        // SocialFollowersFactory.main();
    }
}
