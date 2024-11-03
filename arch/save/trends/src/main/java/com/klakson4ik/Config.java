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

public class Config {
    private static RemoteWebDriver driver;
    //private static DesiredCapabilities capabilities;
    private static FirefoxOptions firefoxOptions;

    {
    //  capabilities = new DesiredCapabilities();
        firefoxOptions = new FirefoxOptions();
    }

    public Config() {
        init();
    }

    private static void init() {
        System.setProperty("webdriver.gecko.driver", "/usr/local/bin/geckodriver");
        // System.setProperty("webdriver.firefox.marionette", "false");
        //DesiredCapabilities capabilities = new DesiredCapabilities();
        FirefoxProfile profile = new FirefoxProfile();
        profile.setPreference("intl.accept_languages", "en-GB");
        firefoxOptions.setProfile(profile);
        //firefoxBinary.addCommandLineOptions("--headless");
        //firefoxOptions.setBinary(firefoxBinary);
        firefoxOptions.setHeadless(true);
        firefoxOptions.setCapability("pageLoadStrategy", "normal");
        //capabilities.setBrowserName("firefox");
        //capabilities.setCapability("pageLoadStrategy", "eager");
        try {
            // driver = new RemoteWebDriver(new URL("http://selenium-hub:4444/wd/hub"), firefoxOptions);
            driver = new RemoteWebDriver(new URL("http://127.0.0.1:4444/wd/hub"), firefoxOptions);
            // System.out.println(driver.getCapabilities());
            // throw new MalformedURLException();
        }
        catch(MalformedURLException e) {
            driver.quit();
        }
    }

    public static RemoteWebDriver getDriver(){
        return driver;
    }
}
