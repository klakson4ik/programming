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

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;
 import org.openqa.selenium.WindowType;
 import java.util.concurrent.TimeUnit;

public class LivejournalShare extends InitDriver{
    final private String LIVEJOURNAL_URL = "https://www.livejournal.com";
    final private String EMAIL = "gonomax";
    final private String PASSWORD = "Ntktdbpjh59!";

    public LivejournalShare(){
        super();
        System.out.println(" Facebook download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.manage().timeouts().pageLoadTimeout(30000, TimeUnit.MILLISECONDS);
            driver.get(LIVEJOURNAL_URL + "/login.bml");
            WebElement email = wait.until(presenceOfElementLocated(By.id("user")));
            email.sendKeys(EMAIL + Keys.TAB + PASSWORD, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            driver.findElement(By.xpath("//button[contains(text(), \"Save\")]"));
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
        byte count = 0; 
        for (Node node : TrendsData.getList()){
            if(count == 5){
                break;
            }
            try{
                String literal = "</?B>|</?EM>|&quot;";
                Pattern pattern = Pattern.compile(literal, Pattern.CASE_INSENSITIVE);
                Matcher matcher = pattern.matcher(node.getDescription());
                String description = matcher.replaceAll("");
                String hashTags = hashTagsCreate(node);
                String url = "https://gonomax.com/news/index?id=" + node.getID();
                driver.get(LIVEJOURNAL_URL + "/update.bml?subject=" + node.getTitle() + "&event=%3Cimg%20src=%22" + node.getImagesFull().get(0) + "%22%3E%0A%3Cp%3E" + description + "%20%3Ca%20href=%22" + url + "%22%3Eread%20more...%3C/a%3E%3C/p%3E&prop_taglist=" + hashTags);
                WebElement buttonShare = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//span[contains(text(), \"Tune in and publish\")]/parent::button")));
                buttonShare.click();
                WebElement buttonPublish = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//span[contains(text(), \"Publish\")]")));
                buttonPublish.click();
                Thread.sleep(3000);
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
