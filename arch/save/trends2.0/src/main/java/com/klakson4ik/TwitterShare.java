package com.klakson4ik;

import org.openqa.selenium.By;
import java.net.URL;
import java.net.MalformedURLException;
import java.net.URISyntaxException;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.interactions.Actions;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import static org.openqa.selenium.support.ui.ExpectedConditions.visibilityOfElementLocated;
import java.time.Duration;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.util.Set;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;
 import org.openqa.selenium.WindowType;
 import java.util.concurrent.TimeUnit;
import java.util.List;
import java.util.ArrayList;

public class TwitterShare extends InitDriver{
    final private String TWITTER_URL = "https://twitter.com/";
    final private String EMAIL = "gonomaxnews";
    final private String PASSWORD = "Ntktdbpjh59!";

    public TwitterShare(){
        super();
        System.out.println("Twitter download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.get(TWITTER_URL + "login");
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'Log in')]")));
            driver.findElement(By.tagName("html")).sendKeys(Keys.TAB, EMAIL + Keys.TAB + PASSWORD + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'Home')]")));
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
        byte count = 0; 
        for (Node node : TrendsData.getList()){
            if(count == 5){
                break;
            }
            String hashTags = hashTagsCreate(node);
            String shareUrl = TWITTER_URL + "intent/tweet?text=" + node.getTitle() + "&url=https://gonomax.com/news/index?id=" + node.getID() + "&via=gonomaxnews&hashtags=" + hashTags; 
            try{
                driver.get(shareUrl);
                wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'gonomax.com')]")));
                driver.findElement(By.xpath("//span[contains(text(), 'Tweet')]")).click();
                ++count;
            }catch(Exception ex){
                continue;
            }
        }
    }

    private String hashTagsCreate(Node node){
        List<String> list = new ArrayList<>();
        String keywords = node.getKeywords();
        String[] split = keywords.split(", ");
        byte count = 0;
        for(String words : split){
            if(count == 4){
                break;
            }
            String[] split2 = words.split(" ");
            List<String> list2 = new ArrayList<>();
            for(String word : split2){
                if(word == null || word.isEmpty()) continue;
                word = word.substring(0, 1).toUpperCase() + word.substring(1);
                list2.add(word);
            }
            String joined = String.join("", list2);
            list.add(joined);
            ++count;
        }
        return String.join(",", list);
    }
}
