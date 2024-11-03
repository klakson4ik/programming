package com.klakson4ik;

import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.firefox.FirefoxBinary;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxOptions;
import org.openqa.selenium.firefox.FirefoxProfile;
import java.net.URL;
import java.net.MalformedURLException;
import java.lang.System;
import java.io.File;
import java.util.concurrent.TimeUnit;

public class Config {
    private static RemoteWebDriver driver;
    private static FirefoxOptions firefoxOptions;

    public Config() {
        firefoxOptions = new FirefoxOptions();
        System.setProperty("webdriver.gecko.driver", "/usr/local/bin/geckodriver");
        // File file = new File("src/main/resources/profile");
        FirefoxProfile profile = new FirefoxProfile();
        profile.setPreference("intl.accept_languages", "en-GB");
        firefoxOptions.setProfile(profile);
        firefoxOptions.setHeadless(true);
        firefoxOptions.setCapability("pageLoadStrategy", "normal");
        try {
            // driver = new RemoteWebDriver(new URL("http://selenium-hub:4444/wd/hub"), firefoxOptions);
           driver = new RemoteWebDriver(new URL("http://127.0.0.1:4444/wd/hub"), firefoxOptions);
            driver.manage().timeouts().implicitlyWait(5000, TimeUnit.MILLISECONDS);
            driver.manage().timeouts().pageLoadTimeout(10000, TimeUnit.MILLISECONDS);
        //    System.out.println(driver.getCapabilities());
        }
        catch(MalformedURLException e) {
            driver.quit();
        }
    }

    public RemoteWebDriver getDriver(){
        return driver;
    }
}
