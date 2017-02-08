package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.eventInterface.AddValueEvent;
import com.podd.eventInterface.MinusValueEvent;
import com.podd.fragment.BreakfastMenuFragment;
import com.podd.fragment.DeliveryMenuFragment;
import com.podd.model.RestaurantMenu;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.SetTimerClass;

import org.greenrobot.eventbus.EventBus;
import org.greenrobot.eventbus.Subscribe;

import java.util.ArrayList;
import java.util.List;

import static com.podd.R.id.tvRestauarntName;


@SuppressWarnings("ALL")
public class ViewMenuDeliveryActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private RecyclerView rvRestaurants;
    private TextView tvRestaurantName,tvTotal,tvTotalPrice;
    private TextView tvBookNow;
    private LinearLayout llViewTotalPrice;
    private ArrayList<String> restaurantImages;
    private ArrayList<RestaurantMenu> restaurantMenu;
    private String restaurantName;
    private String restaurantId;
    private String location;
    private TabLayout tabLayout;
    private ViewPager viewPager;
    private ViewPagerAdapter adapter;
    private SetTimerClass setTimerClass;
    public  double price=0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_menu);
        context = ViewMenuDeliveryActivity.this;
        EventBus.getDefault().register(this);
        getIds();
        setListeners();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();
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
        if(restaurantMenu.size()==0){
            CommonUtils.showAlertOk("Currently, no menu item is available.",ViewMenuDeliveryActivity.this);
        }

        // setAdapter();
        setupViewPager(viewPager);
        tabLayout.setupWithViewPager(viewPager);

        // Iterate over all tabs and set the custom view
        for (int i = 0; i < tabLayout.getTabCount(); i++) {
            TabLayout.Tab tab = tabLayout.getTabAt(i);
            tab.setCustomView(adapter.getTabView(i));
        }
    }

    private void getIds() {
        llViewTotalPrice = (LinearLayout) findViewById(R.id.llViewTotalPrice);
        llViewTotalPrice.setVisibility(View.VISIBLE);
        rvRestaurants = (RecyclerView) findViewById(R.id.rvRestaurants);
        tvRestaurantName = (TextView) findViewById(tvRestauarntName);
        tvBookNow = (TextView) findViewById(R.id.tvBookNow);
        tvTotal = (TextView) findViewById(R.id.tvTotal);
        tvTotalPrice = (TextView) findViewById(R.id.tvTotalPrice);
        tvTotalPrice.setText("£ "+price);
        tabLayout = (TabLayout) findViewById(R.id.tab_layout);
        viewPager = (ViewPager) findViewById(R.id.view_pager);

    }

    private void setFont() {
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvRestaurantName.setTypeface(typefaceBold);
        tvBookNow.setTypeface(typefaceBold);
        tvTotal.setTypeface(typefaceBold);
        tvTotalPrice.setTypeface(typefaceBold);
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
                if(validationPrice()){
                    Intent intent = new Intent(context, DeliveryBookingDetailsActivity.class);
                    intent.putExtra(AppConstant.RESTAURANTIMAGES, restaurantImages);
                    intent.putExtra(AppConstant.RESTAURANTID, restaurantId);
                    intent.putExtra(AppConstant.RESTAURANTNAME, restaurantName);
                    intent.putExtra(AppConstant.LOCATION, location);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }

                break;
        }
    }

    private boolean validationPrice() {
        if (!tvTotalPrice.getText().toString().trim().equalsIgnoreCase("£ 0.0")) {
            return true;
        } else {
            Toast.makeText(this, "Please select an item.", Toast.LENGTH_SHORT).show();
            return false;
        }
    }


    private void setupViewPager(ViewPager viewPager) {
        adapter = new ViewPagerAdapter(getSupportFragmentManager());
        for (int i = 0; i < restaurantMenu.size(); i++) {
            adapter.addFragment(new DeliveryMenuFragment().newInstance(restaurantMenu,restaurantMenu.get(i).meal_details), restaurantMenu.get(i).meal_name);
        }

        viewPager.setAdapter(adapter);
    }

    class ViewPagerAdapter extends FragmentPagerAdapter {
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

        public View getTabView(int position) {
            View tab = LayoutInflater.from(ViewMenuDeliveryActivity.this).inflate(R.layout.custom_tab_text, null);
            TextView tv = (TextView) tab.findViewById(R.id.custom_text);
            Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
            tv.setTypeface(typefaceRegular);
            tv.setText(mFragmentTitleList.get(position).toString());
            return tab;
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return mFragmentTitleList.get(position);
        }

    }

    @Subscribe
    public void onEventMainThread(AddValueEvent addValueEvent) {
        price = price + addValueEvent.value;
        tvTotalPrice.setText("£ " + price/*SetTimerClass.getTotalPrice()*/);

    }

    @Subscribe
    public void onEventMainThread(MinusValueEvent minusValueEvent) {
        price = price - minusValueEvent.value;

        tvTotalPrice.setText("£ " + price/*SetTimerClass.getTotalPrice()*/);

    }


    @Override
    protected void onResume() {
        super.onResume();
        setTimerClass.setTimer(this, true);


    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        setTimerClass.setTimer(this, true);
    }

    @Override
    public void onUserInteraction() {
        super.onUserInteraction();
        setTimerClass.setTimer(this, false);
    }


}

