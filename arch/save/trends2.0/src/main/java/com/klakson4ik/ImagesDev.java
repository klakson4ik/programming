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
import java.net.URLDecoder;
import java.nio.charset.StandardCharsets;
import java.io.UnsupportedEncodingException;

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;

public class ImagesDev extends InitDriver{
    private List<String>images;
    private List<String>imagesFull;
    private List<String>imagesAlt;
    private List<WebElement> imagesBlock;
    private WebElement block;
    private int timeLoadImages;
    final private String SELECTOR_URL = "Images";
    final private String SELECTOR_BLOCK = "islmp";
    final private String SELECTOR_IMAGES_BLOCK = "rg_i";
    final private String SELECTOR_IMAGES_FULL_BLOCK = "BIB1wf";
    final private String SELECTOR_IMAGES_FULL = "n3VNCb";

    public ImagesDev(){
        super();
        String stringTimeLoadImages = Props.getProp("timeloadimages");
        timeLoadImages = Integer.parseInt(stringTimeLoadImages.trim());
        System.out.println("Images page download");
        createTrendsData();
       // String url = "https://s1.ibtimes.com/sites/www.ibtimes.com/files/styles/full/public/2020/08/20/houssem-aouar-in-action-against-bayern-munich-he.jpg";
        // editImageUrl(url);
        System.out.println("Images save");
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            // String[] words = {"machine", "bullet", "system of daiving"};
            String[] words = {"burger point zevs", "allow comment flex", "hup on hof the strong", "plain break bullet", "man people pink"};
            for(String word : words){
            driver.get("https://www.google.com/search?client=firefox-b-d&q=" + word);
            String imagesUrl = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//a[text()=\'" + SELECTOR_URL  +"\']"))).getAttribute("href");        
            driver.get(imagesUrl);
            block = wait.until(visibilityOfElementLocated(By.xpath("//div[@id=\'" + SELECTOR_BLOCK  + "\']")));
            imagesBlock = new ArrayList<WebElement>();
            imagesBlock = block.findElements(By.className(SELECTOR_IMAGES_BLOCK));
            images = new ArrayList<String>();
            imagesFull = new ArrayList<String>();
            imagesAlt = new ArrayList<String>();
            byte count = 0;
            String https = "https://";
            Pattern httpsP = Pattern.compile(https, Pattern.CASE_INSENSITIVE);
            for (WebElement imageBlock : imagesBlock){
                if(count == 20){
                    break;
                }
                imageBlock.click();
                WebElement imageFullBlock = wait.until(ExpectedConditions.presenceOfElementLocated(By.className(SELECTOR_IMAGES_FULL_BLOCK)));
                String imageFullSrc = imageFullBlock.findElement(By.className(SELECTOR_IMAGES_FULL)).getAttribute("src");
                    if(!httpsP.matcher(imageFullSrc).find()){
                        continue;
                    }
                    System.out.println(imageFullSrc);
                    String imageFinalImageSrc = imageFullSrc;
                    // if(count == 0){
                        imageFinalImageSrc = editImageUrl(imageFullSrc);
                        if(imageFinalImageSrc == null){
                            continue;
                        // }
                    }
                    images.add(imageBlock.getAttribute("src"));
                    imagesAlt.add(imageBlock.getAttribute("alt"));
                    imagesFull.add(imageFinalImageSrc);
                    count++;
            }
            }
        } catch (Exception e) {
            driver.quit();
            e.printStackTrace();
        }
    }

    private String editImageUrl(String url){
        String finalUrl = "";
        String prop = Props.getProp("dns-suffixes");
        String[] suffixes = prop.split(",");
        for(String suffix : suffixes){
            String domain = "\\b." + suffix + "\\b";
            Pattern p = Pattern.compile(domain);
            Matcher m = p.matcher(url);
            Pattern urlPattern = Pattern.compile("(?<!/)/[A-Za-z0-9-_.]+\\b" + domain +  "\\b.+");
            byte count = 0;
            while(m.find()){
                String b =  m.group();
                ++count;
                if(count > 1){
                    System.out.println("1");
                    System.out.println(b);
                    Matcher t = urlPattern.matcher(url);
                    while(t.find()){
                        String g = t.group();
                        System.out.println(g);
                        try{
                            System.out.println("2");
                            System.out.println(g);
                            URL urlIm = new URL("https:/" + g);
                            InputStream is = urlIm.openStream();
                            System.out.println("3");
                            return "https:/" + g;
                        }
                        catch(MalformedURLException e){
                            System.out.println("4");
                            return url;
                        }
                        catch(IOException e){
                            try{
                                System.out.println("5");
                                URL urlEx = new URL(url);
                                InputStream isEx  = urlEx.openStream();
                                System.out.println("6");
                                return url;
                            }catch (IOException ex){
                                System.out.println("7");
                                return null;
                            }
                        }
                    }
                }
            }
        }
        try{
            System.out.println("8");
            URL urlEx = new URL(url);
            InputStream isEx  = urlEx.openStream();
            System.out.println("9");
            return url;
        }catch (IOException ex ){
            System.out.println("10");
            return null;
        }
    }
}
