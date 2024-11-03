package com.klakson4ik;

import java.util.ArrayList;
import java.util.List;

public class Links {
    private String prop;
    private List<String[]> dataLinks = new ArrayList<>();


    public Links(){
        createLinks();
    }

    private void createLinks () {
        prop = Props.getProp("links");
        String[] lines = prop.split(";");
        for(String line : lines){
            String[] words = line.split(",");
            FactoryNews factory = choiceFactory(words[0]);
            Locale news = choiceLocale(factory, words[1]);
            String[] array = new String[2];
            array[0] = news.interact(words[2]);
            array[1] = words[3];
            dataLinks.add(array);
        }
    }

    private FactoryNews choiceFactory(String factory){
        switch(factory){
            case "daily":
                return new DailyNewsFactory();
            case "realtime":
                return new RealtimeNewsFactory();
            default:
                throw new RuntimeException("doesn`t exists " + factory);
        }
    }

    private Locale choiceLocale(FactoryNews factory, String locale){
        switch(locale){
            case "US":
                return factory.createLocaleUS();
            case "AU":
                return factory.createLocaleAU();
            case "GB":
                return factory.createLocaleGB();
            case "CA":
                return factory.createLocaleCA();
            default:
                throw new RuntimeException("doesn`t exists " + locale);
        }
    }

    public List<String[]> getDataLinks(){
        return dataLinks;
    }
}

interface FactoryNews {
    Locale createLocaleUS();
    Locale createLocaleAU();
    Locale createLocaleGB();
    Locale createLocaleCA();
}

abstract class Locale{
    protected final String TRENDS ="https://trends.google.us/trends/trendingsearches/";
    protected final String US = "geo=US";
    protected final String AU = "geo=AU";
    protected final String GB = "geo=GB";
    protected final String CA = "geo=CA";

    abstract protected String interact(String value);
}

abstract class DailyLocale extends Locale{
    protected final String TYPE_NEWS = "daily?";
    
}

abstract class RealtimeLocale extends Locale{
    protected final String TYPE_NEWS = "realtime?";
    protected final String CATEGORY = "&category=";
}

class RealtimeNewsFactory implements FactoryNews {

    @Override
    public Locale createLocaleUS() {
        return new RealtimeNewsUS();
    }
    @Override
    public Locale createLocaleAU() {
        return new RealtimeNewsAU();
    }
    @Override
    public Locale createLocaleGB() {
        return new RealtimeNewsGB();
    }
    @Override
    public Locale createLocaleCA() {
        return new RealtimeNewsCA();
    }
}

class DailyNewsFactory implements FactoryNews {

    @Override
    public Locale createLocaleUS() {
        return new DailyNewsUS();
    }
    @Override
    public Locale createLocaleAU() {
        return new DailyNewsAU();
    }
    @Override
    public Locale createLocaleGB() {
        return new DailyNewsGB();
    }
    @Override
    public Locale createLocaleCA() {
        return new DailyNewsCA();
    }
}

class RealtimeNewsUS extends RealtimeLocale  {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + US + CATEGORY + value;
    } 
}

class RealtimeNewsAU extends RealtimeLocale  {
 @Override
    public String interact(String value) {
         return TRENDS + TYPE_NEWS + AU + CATEGORY + value;
    }
}

class RealtimeNewsGB extends RealtimeLocale  {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + GB + CATEGORY + value;
    }
}

class RealtimeNewsCA extends RealtimeLocale {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS  + CA + CATEGORY + value;
    }
}

class DailyNewsUS extends DailyLocale {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + US;
    }
}

class DailyNewsAU extends DailyLocale {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + AU;
    }
}

class DailyNewsGB extends DailyLocale {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + GB;
    }
}

class DailyNewsCA extends DailyLocale {
 @Override
    public String interact(String value) {
        return TRENDS + TYPE_NEWS + CA;
    }
}
