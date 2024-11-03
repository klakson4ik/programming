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

public class FacebookShareDev extends InitDriver{
    final private String FB_URL = "https://www.facebook.com";
    final private String EMAIL = "gonomaxnews@gmail.com";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String FB_HTML_CLASS = "_9dls";
    final private String SELECTOR_BUTTON_SHARE = "layerConfirm";
    final private String SHARE_URL = "/sharer.php?u=https%3A%2F%2Fgonomax.com%2Fnews%2Findex%3Fid%3D";
    final private String ID = "6060";

    public FacebookShareDev(){
        super();
        System.out.println(" Facebook download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.get(FB_URL);
            driver.findElement(By.id("email")).sendKeys(EMAIL + Keys.TAB + PASSWORD + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.className(FB_HTML_CLASS)));

                driver.get(FB_URL + SHARE_URL + ID);
                wait.until(ExpectedConditions.elementToBeClickable(By.className(SELECTOR_BUTTON_SHARE)));
                driver.findElement(By.tagName("body")).sendKeys("DESCRIPTION" + Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            wait.until(presenceOfElementLocated(By.className("sidebarMode")));
                Thread.sleep(5000);
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
    }
}
