package com.klakson4ik;

import java.util.List;
import java.util.ArrayList;

public class CheckExistNewsInDB extends Init {

    public CheckExistNewsInDB(){
        createTrendsData();
    }

    protected void createTrendsData() {
        ModelDB.checkInDB();
    }
}
