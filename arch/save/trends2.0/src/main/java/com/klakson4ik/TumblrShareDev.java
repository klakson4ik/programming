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
import org.openqa.selenium.support.ui.ExpectedConditions;
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

public class TumblrShareDev extends InitDriver{
    final private String TUMBLR_URL = "https://www.Tumblr.com";
    final private String EMAIL = "gonomaxnews@gmail.com";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String SHARE_URL = "/widgets/share/tool?canonicalUrl=http://gonomax.com/news/index?id=";
    final private String ID = "6060";

    public TumblrShareDev(){
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

            driver.get("https://www.tumblr.com/widgets/share/tool?canonicalUrl=https://gonomax.com/news/index?id=6811&title=Boston Celtics vs. Denver Nuggets live stream, TV channel, start time, how to watch NBA summer league&caption=Want some action on the <B>NBA <B>Summer League</B></B>? Place your legal sports bets on this game or others in CO, IN, NJ, and WV at ..&tags=LiangeloBall,NbaSummerLeague,SummerLeagueSchedule,NbaSummerLeagueScores,NbaSummerLeagueSchedule");
            WebElement button =  wait.until(presenceOfElementLocated(By.xpath("//button[contains(text(), 'Next')] | //button[contains(text(), 'Post')]")));
            System.out.println(button.getText());
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
            // buttonPost.click();
            wait.until(presenceOfElementLocated(By.xpath("//a[contains(text(), 'gonomax')]")));
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
    }
}
