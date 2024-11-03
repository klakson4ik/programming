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

public class BoilerPipeDev extends Init {
    private String text;
    private String urlLine = "https://californianewstimes.com/look-up-stargazers-twin-meteor-showers-will-light-up-the-night-sky-to-close-out-july/459612/";

    public BoilerPipeDev(){
        createTrendsData();
    }

    protected void createTrendsData(){
        createFinalText();
    }

    private void createFinalText(){
        try{
            URL url = new URL(urlLine);
            final BoilerpipeExtractor extractor = CommonExtractors.ARTICLE_EXTRACTOR;
            final HtmlArticleExtractor htmlExtr = HtmlArticleExtractor.INSTANCE;
            text = htmlExtr.process(extractor, url);
        }
        catch(IOException e) {
        //  e.printStackTrace();
        }
        catch(BoilerpipeProcessingException e) {
            e.printStackTrace();
        }
        catch(SAXException e) {
            e.printStackTrace();
        }
        catch(URISyntaxException e){
            e.printStackTrace();
        }
        String literal = Props.getProp("pattern");
        String replacer = Props.getProp("replacer");

        Pattern pattern = Pattern.compile(literal, Pattern.COMMENTS);
        Matcher matcher = pattern.matcher(text);
        text = matcher.replaceAll(replacer);
        System.out.println(text);
        System.out.println("========================================================");

        literal = "<(H1|H2|H3)>.*?Look up, stargazers! Twin meteor showers will light up the night sky to close out July.*?</\\1>";
        pattern = Pattern.compile(literal, pattern.CASE_INSENSITIVE);
        matcher = pattern.matcher(text);
        text = matcher.replaceFirst(replacer);
        System.out.println(text);
        System.out.println("========================================================");
        createDescription();
        
        // pattern = Pattern.compile("</P>", Pattern.COMMENTS);
        // int count = 0;
        // // System.out.println("========================================================");
        // matcher = pattern.matcher(text);
        
        // while (matcher.find()) {
        //     ++count;
        // }
        // choiceCountImages(count);

    }

    private void createDescription(){
        String strKeywords = "spectacular";
        String[] keywords = strKeywords.split(", ");
        String finalText = "";
        String badTags = "</?P>|<A.*?>.*?</A>|</?B>|<TIME.*?>.*?</TIME>|</?STRONG>";
        boolean if_is = false;
        String literalKeyword = "<P>.+?</P>";
        Pattern pattern = Pattern.compile(literalKeyword);
        Matcher matcher = pattern.matcher(text);
        for(String keyword : keywords){
            while(matcher.find()){
                String g = matcher.group();
                String keywordP = "\\b" + keyword + "\\b";
                Pattern eachP = Pattern.compile(keywordP, Pattern.CASE_INSENSITIVE);
                Matcher eachM = eachP.matcher(g);
                if(eachP.matcher(g).find()){
                    Pattern p = Pattern.compile(badTags, Pattern.COMMENTS);
                    Matcher m = p.matcher(g);
                    System.out.println(g);
                    finalText += m.replaceAll("").trim() + ". ";
                    System.out.println("++++++++++++++++++++++++++++++++");
                    System.out.println(finalText);
                    String finalKeyword = "";
                    while(eachM.find()){
                        char[] dst = new char[eachM.end() - eachM.start()];
                        g.getChars(eachM.start(), eachM.end(), dst, 0);
                        finalKeyword = String.valueOf(dst);
                    }
                    finalText = finalText.replace(finalKeyword, "<B>" + finalKeyword + "</B>");
                    if(finalText.length() > 135){
                        finalText = finalText.substring(0, 140);
                        finalText = finalText.replaceAll("(.+)\\s+\\S+$", "$1");
                        if_is = true;
                        break;
                    }
                break;
                }
            }
            if(if_is){
                break;
            }
            matcher.reset();
        }
        if(finalText.length() < 135){
            matcher.reset();
            while(matcher.find()){
                String g = matcher.group();
                Pattern p = Pattern.compile(badTags);
                Matcher m = p.matcher(g);
                finalText += m.replaceAll("").trim() + ". ";
                if(finalText.length() > 135){
                    finalText = finalText.substring(0, 140);
                    finalText = finalText.replaceAll("(.+)\\s+\\S+$", "$1");
                    break;
                }
            }
        }
        finalText = finalText.trim();
        System.out.println(finalText);
    }

    private void choiceCountImages(int count){
        if(text.length() >= 8000)
            imageAddToText(count/5, 4);
        else if(text.length() >= 6000)
            imageAddToText(count/4, 3);
        else if(text.length() >= 4000)
            imageAddToText(count/3, 2);
        else if(text.length() >= 2000)
            imageAddToText(count/2, 1);
        else
            System.out.println(text);
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
        System.out.println(text);
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
