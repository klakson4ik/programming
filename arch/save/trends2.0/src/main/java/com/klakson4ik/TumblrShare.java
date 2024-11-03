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
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import org.openqa.selenium.NoSuchElementException;

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;
 import org.openqa.selenium.WindowType;
 import java.util.concurrent.TimeUnit;

public class TumblrShare extends InitDriver{
    final private String TUMBLR_URL = "https://www.Tumblr.com";
    final private String EMAIL = "gonomaxnews@gmail.com";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String SELECTOR_BUTTON_SHARE = "layerConfirm";
    final private String SHARE_URL = "/widgets/share/tool?canonicalUrl=https://gonomax.com/news/index?id=";

    public TumblrShare(){
        super();
        System.out.println("Tumblr  download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.get(TUMBLR_URL + "/login");
            driver.findElement(By.id("tumblr")).sendKeys(EMAIL + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'Log in')]")));
            driver.findElement(By.id("tumblr")).sendKeys(PASSWORD + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.xpath("//h1[contains(text(), 'Radar')]")));
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
        byte count = 0; 
        for (Node node : TrendsData.getList()){
            if(count == 8){
                break;
            }
            try{
                String title = node.getTitle();
                String description = node.getDescription();
                String hashTags = hashTagsCreate(node);
                String ID = node.getID();
                driver.get(TUMBLR_URL + SHARE_URL + ID + "&title=" + title + "&caption=" + description + "&tags=" + hashTags);
                WebElement button =  wait.until(presenceOfElementLocated(By.xpath("//button[contains(text(), 'Next')] | //button[contains(text(), 'Post')]")));
                if(button.getText().equals("Next")){
                    List<WebElement> images = driver.findElements(By.className("hover"));
                    for (WebElement image : images){
                        image.click();
                    }
                    WebElement buttonNext = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//button[contains(text(), 'Next')]")));
                    buttonNext.click();
                }else{
                    WebElement desc = driver.findElement(By.className("editor-richtext"));
                    desc.findElement(By.tagName("p")).clear();
                }
                WebElement buttonPost = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//button[contains(text(), 'Post')]")));
                buttonPost.click();
                wait.until(presenceOfElementLocated(By.xpath("//a[contains(text(), 'gonomax')]")));
                ++count;
            }catch (Exception ex){
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
            if(count == 8){
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
