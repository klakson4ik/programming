package com.klakson4ik;

//import org.openqa.selenium.TimeoutException;
import java.lang.InterruptedException;
import java.net.URL;
import java.net.MalformedURLException;
import java.util.Timer;
import java.util.TimerTask;


import de.l3s.boilerpipe.BoilerpipeExtractor;
import de.l3s.boilerpipe.BoilerpipeProcessingException;
import de.l3s.boilerpipe.document.Media;
import de.l3s.boilerpipe.extractors.CommonExtractors;
import de.l3s.boilerpipe.sax.HtmlArticleExtractor;
import de.l3s.boilerpipe.sax.MediaExtractor;
import java.io.IOException;
import org.xml.sax.SAXException;
import java.net.URISyntaxException;

import java.util.List;
import java.util.ArrayList;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;
import java.lang.Runnable;
import java.lang.Runtime;
import java.lang.Thread;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

public class BoilerPipe {
    private String text;
    private RealtimeNode node;

    public BoilerPipe(RealtimeNode node){
        this.text = node.getText();
        this.node = node;
        textEditor();
    }

    private void textEditor(){
        String PATH_TO_PROPERTIES = "/home/maks/trends/config.properties";
        FileInputStream fileInputStream;
        Properties prop = new Properties();

        try {
            fileInputStream = new FileInputStream(PATH_TO_PROPERTIES);
            prop.load(fileInputStream);
            String pattern = prop.getProperty("pattern");
        } catch (IOException e) {
            System.out.println("file not found " + PATH_TO_PROPERTIES);
            e.printStackTrace();
        }
        String literal = prop.getProperty("pattern");
        String replacer = prop.getProperty("replacer");

        Pattern pattern = Pattern.compile(literal, Pattern.COMMENTS);
        Matcher matcher = pattern.matcher(text);
        text = matcher.replaceAll(replacer);

        literal = "<(H1|H2|h3)>.*" + node.getTitle()  + ".*</\\1>";
        pattern = Pattern.compile(literal, Pattern.COMMENTS);
        matcher = pattern.matcher(text);
        text = matcher.replaceAll(replacer);
        
        pattern = Pattern.compile("</P>", Pattern.COMMENTS);
        int count = 0;
        matcher = pattern.matcher(text);
        
        while (matcher.find()) {
            ++count;
        }

        if(text.length() >= 8000)
            imageAddToText(count/5, 4);
        else if(text.length() >= 6000)
            imageAddToText(count/4, 3);
        else if(text.length() >= 4000)
            imageAddToText(count/3, 2);
        else if(text.length() >= 2000)
            imageAddToText(count/2, 1);
        else if(text.length() >= 700)
            node.setText(text);
        else
            node.setText(text);

    }

    private void imageAddToText(int step, int countImages){
        int countMatch = 0;
        String newText = ""; 
        int nextStep = step;
        Pattern pattern = Pattern.compile("</P>", Pattern.COMMENTS);
        String[] fields = pattern.split(text);
        for (int i = 1; i < fields.length; i++){
            if(i == nextStep && countMatch != countImages ){
                newText += fields[i] + "</P>" + getImageText(++countMatch);
                nextStep+=step;
            }else
                newText += fields[i] + "</P>";

        }
        node.setText(newText);
    }

    private String getImageText(int countMatch){
        String imageText = "<div class=\"news-block-img\">" + 
                            "\t<img class=\"news-img\" src=\"" + node.getImagesFull().get(countMatch)  + "\" alt=\"" + node.getImagesAlt().get(countMatch)  + "\">" +
                            "\t<div class=\"news-img-signature\">" + node.getImagesAlt().get(countMatch)  + "</div>" +
                            "</div>";
        return imageText; 
    }

    public String getText(){
        return text;
    }
}
