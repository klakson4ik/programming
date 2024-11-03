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
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfAllElementsLocatedBy;
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
 import java.util.Random;

public class FacebookFollowersDev extends InitDriver{
    final private String FB_URL = "https://www.facebook.com";
    final private String EMAIL = "gonomaxnews@gmail.com";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String SEARCH_URL = "/search/people?q=";
    final private String FB_HTML_CLASS = "_9dls";

    public FacebookFollowersDev(){
        super();
        System.out.println(" FacebookShare start");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.get(FB_URL);
            driver.findElement(By.id("email")).sendKeys(EMAIL + Keys.TAB + PASSWORD + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.className(FB_HTML_CLASS)));
            driver.get(FB_URL);
            String prop = Props.getProp("facebook-followers-name");
            String[] arrayName = prop.split(",");
            Random rand = new Random();
            int randomNum = rand.nextInt(arrayName.length);
            driver.get(FB_URL + SEARCH_URL + arrayName[randomNum]);
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'City')]")));
            driver.findElement(By.xpath("//span[contains(text(), 'City')]/parent::span/parent::div/parent::div/parent::div")).click();
            // townBut.findElement(By.xpath("./parent::span/parent::div/parent::div/parent::div")).click();
            // townBut.click();
            wait.until(presenceOfElementLocated(By.cssSelector("input[placeholder=\"Choose a town or city...\"]")));
            WebElement townButt = driver.findElement(By.cssSelector("input[placeholder=\"Choose a town or city...\"]"));
            prop = Props.getProp("facebook-followers-town");
            String[] arrayTown = prop.split(",");
            rand = new Random();
            randomNum = rand.nextInt(arrayTown.length);
            townButt.sendKeys(arrayTown[randomNum]);
            Thread.sleep(2000);
            townButt.sendKeys(Keys.DOWN, Keys.ENTER);
            // townButt.sendKeys(Keys.DOWN);
            Thread.sleep(3000);
            wait.until(presenceOfElementLocated(By.cssSelector("div[aria-label=\"Add Friend\"]")));
            List<WebElement> addFriends = driver.findElements(By.cssSelector("div[aria-label=\"Add Friend\"]"));
            byte count = 0; 
            for (WebElement addFriend : addFriends){
                if(count >= 5){
                    break;
                }
                Thread.sleep(5000);
                addFriend.click();
            }
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
    }
}
