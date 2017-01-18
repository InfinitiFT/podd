package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.TextView;

import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.fragment.BreakfastMenuFragment;
import com.podd.fragment.DinnerMenuFragment;
import com.podd.fragment.LunchMenuFragment;
import com.podd.model.RestaurantMenu;
import com.podd.utils.AppConstant;

import java.util.ArrayList;
import java.util.List;

/**
 * The type View menu activity.
 */
@SuppressWarnings("ALL")
public class ViewMenuActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private RecyclerView rvRestaurants;
    private TextView tvRestaurantName;
    private TextView tvBookNow;
    private ArrayList<String> restaurantImages;
    private ArrayList<RestaurantMenu> restaurantMenu;
    private String restaurantName;
    private String restaurantId;
    private String location;
    private TabLayout tabLayout;
    private ViewPager viewPager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_menu);
        context = ViewMenuActivity.this;
        getIds();
        setListeners();
        restaurantImages = (ArrayList<String>) getIntent().getSerializableExtra(AppConstant.RESTAURANTIMAGES);
        restaurantName = getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
        restaurantId = getIntent().getStringExtra(AppConstant.RESTAURANTID);
        location = getIntent().getStringExtra(AppConstant.LOCATION);
        tvRestaurantName.setText(restaurantName);
        Bundle bundle = new Bundle();
        bundle = getIntent().getBundleExtra(AppConstant.RESTAURANTMENUBUNDLE);
        if (bundle != null) {
            restaurantMenu = (ArrayList<RestaurantMenu>) bundle.getSerializable(AppConstant.RESTAURANTMENU);
        }

        setAdapter();
        setupViewPager(viewPager);
        tabLayout.setupWithViewPager(viewPager);
    }

    private void getIds() {

        rvRestaurants = (RecyclerView) findViewById(R.id.rvRestaurants);
        tvRestaurantName = (TextView) findViewById(R.id.tvRestauarntName);
        tvBookNow = (TextView) findViewById(R.id.tvBookNow);
        tabLayout = (TabLayout) findViewById(R.id.tab_layout);
        viewPager = (ViewPager) findViewById(R.id.view_pager);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
    }


    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context, restaurantImages);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context, LinearLayoutManager.HORIZONTAL, false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvBookNow:

                Intent intent = new Intent(context, RestaurantBookingDetailsActivity.class);
                intent.putExtra(AppConstant.RESTAURANTIMAGES, restaurantImages);
                intent.putExtra(AppConstant.RESTAURANTID, restaurantId);
                intent.putExtra(AppConstant.RESTAURANTNAME, restaurantName);
                intent.putExtra(AppConstant.LOCATION, location);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;

        }
    }


    private void setupViewPager(ViewPager viewPager) {
        ViewPagerAdapter adapter = new ViewPagerAdapter(getSupportFragmentManager());
        for (int i = 0; i < restaurantMenu.size(); i++) {
            adapter.addFragment(new BreakfastMenuFragment().newInstance(restaurantMenu.get(i).meal_details), restaurantMenu.get(i).meal_name);
        }

        viewPager.setAdapter(adapter);
    }

    private class ViewPagerAdapter extends FragmentPagerAdapter {
        private final List<Fragment> mFragmentList = new ArrayList<>();
        private final List<String> mFragmentTitleList = new ArrayList<>();


        public ViewPagerAdapter(FragmentManager supportFragmentManager) {
            super(supportFragmentManager);
        }


        @Override
        public Fragment getItem(int position) {
            return mFragmentList.get(position);
        }

        @Override
        public int getCount() {
            return mFragmentList.size();
        }

        void addFragment(Fragment fragment, String title) {
            mFragmentList.add(fragment);
            mFragmentTitleList.add(title);
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return mFragmentTitleList.get(position);
        }

    }
}

