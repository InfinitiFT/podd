package com.podd.activityrestauarant;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.widget.ImageView;
import android.widget.TextView;
import com.podd.R;
import com.podd.adapter.HomeItemsAdapter;
import com.podd.model.HomeItemsModel;
import java.util.ArrayList;
import java.util.List;

public class NewHomeScreenActivity extends AppCompatActivity {
    private ImageView ivPodd;
    private TextView tvAdminMessage;
    private TextView tvPersonal;
    private RecyclerView rvHomeItems;
    private HomeItemsAdapter homeItemsAdapter;
    private Context context;
    private List<HomeItemsModel> homeItemsModelList = new ArrayList<>();
    private int itemsImages[]={R.mipmap.icon1,R.mipmap.icon2,R.mipmap.icon3,R.mipmap.icon4,R.mipmap.icon1,R.mipmap.icon2,R.mipmap.icon3,R.mipmap.icon4};
    private String itemsName[] = {"Front\nDesk" , "Food &\nDrinks", "Taxi &\nLimousines", "Car \nHire", "Health &\nWellness", "Beauty \nServices", "Art &\nCulture", "Happening \nin London"};



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_home_screen);
        context=NewHomeScreenActivity.this;
        getIds();
        setRecycler();
        setRecyclerData();

    }

    private void setRecycler() {
        homeItemsAdapter = new HomeItemsAdapter(context,homeItemsModelList);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvHomeItems.setLayoutManager(mLayoutManager);
        rvHomeItems.setAdapter(homeItemsAdapter);
    }

    private void setRecyclerData(){

        for (int i = 0; i < itemsName.length; i++) {
            HomeItemsModel homeItemsModel = new HomeItemsModel();
            homeItemsModel.setItemName(itemsName[i]);
            homeItemsModel.setItemImage(itemsImages[i]);

            homeItemsModelList.add(homeItemsModel);
        }

    }

    private void getIds() {
        ivPodd= (ImageView) findViewById(R.id.ivPodd);
        tvAdminMessage= (TextView) findViewById(R.id.tvAdminMessage);
        tvPersonal= (TextView) findViewById(R.id.tvPersonal);
        rvHomeItems= (RecyclerView) findViewById(R.id.rvHomeItems);
    }


}
