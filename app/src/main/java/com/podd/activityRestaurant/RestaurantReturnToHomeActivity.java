package com.podd.activityRestaurant;

import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import com.podd.R;
import com.podd.adapter.OrderSummaryAdapter;
import com.podd.model.SavedItem;
import com.podd.utils.AppConstant;
import com.podd.utils.SetTimerClass;

import java.util.List;

/**
 * The type Restaurant return to home activity.
 */
public class RestaurantReturnToHomeActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView tvReturnToHome;
    private Context context;
    private Intent intent;
    private TextView tvRestauarntName,tvLocationLeft,tvDateBookedLeft;
    private TextView tvLocation,tvTimeBookedLeft,tvNumberofPeopleLeft;
    private TextView tvDateBooked,tvConfirmation,tvThanks;
    private TextView tvTimeBooked;
    private TextView tvNumberofPeople;
    private LinearLayout llNumberPeople,llRestaurantScreen;
    private SetTimerClass setTimerClass;
    private RecyclerView rvOrderList;
    List<SavedItem> savedItemList;
    private OrderSummaryAdapter orderSummaryAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restaurant_return_to_home);
        context = RestaurantReturnToHomeActivity.this;
        getIds();
        setListeners();
        setFont();
        setTimerClass = (SetTimerClass)getApplication();

        /*this condition get the data from booking summary screen*/
        if(getIntent()!=null) {
            if(getIntent().getStringExtra(AppConstant.Delivery).equalsIgnoreCase("1")){
                llRestaurantScreen.setVisibility(View.GONE);
                llNumberPeople.setVisibility(View.GONE);
                rvOrderList.setVisibility(View.VISIBLE);
                tvRestauarntName.setText(getIntent().getStringExtra(AppConstant.RESTAURANTNAME));
               /* tvLocation.setText(getIntent().getStringExtra(AppConstant.LOCATION));
                tvTimeBooked.setText(getIntent().getStringExtra(AppConstant.TIMEBOOKED));
                tvDateBooked.setText(getIntent().getStringExtra(AppConstant.DATEBOOKED));*/
                tvConfirmation.setText(R.string.delivery_message);
            }else if(getIntent().getStringExtra(AppConstant.Delivery).equalsIgnoreCase("0")){
                tvRestauarntName.setText(getIntent().getStringExtra(AppConstant.RESTAURANTNAME));
                tvLocation.setText(getIntent().getStringExtra(AppConstant.LOCATION));
                tvTimeBooked.setText(getIntent().getStringExtra(AppConstant.TIMEBOOKED));
                tvDateBooked.setText(getIntent().getStringExtra(AppConstant.DATEBOOKED));
                tvNumberofPeople.setText(getIntent().getStringExtra(AppConstant.NOOFPEOPLE));
                tvConfirmation.setText(R.string.confirmation_text);
            }
        }else{
            tvRestauarntName.setText("");
            tvLocation.setText("");
            tvTimeBooked.setText("");
            tvDateBooked.setText("");
            tvNumberofPeople.setText("");
        }

        savedItemList = SetTimerClass.savedList;
        orderSummaryAdapter = new OrderSummaryAdapter(this, savedItemList);
        rvOrderList.setAdapter(orderSummaryAdapter);
        rvOrderList.setLayoutManager(new LinearLayoutManager(this));
    }

    private void getIds() {
        tvReturnToHome = (TextView) findViewById(R.id.tvReturnToHome);
        tvRestauarntName = (TextView) findViewById(R.id.tvRestauarntName);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvDateBooked = (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked = (TextView) findViewById(R.id.tvTimeBooked);
        tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);
        tvLocationLeft = (TextView) findViewById(R.id.tvLocationLeft);
        tvDateBookedLeft = (TextView) findViewById(R.id.tvDateBookedLeft);
        tvTimeBookedLeft = (TextView) findViewById(R.id.tvTimeBookedLeft);
        tvNumberofPeopleLeft = (TextView) findViewById(R.id.tvNumberofPeopleLeft);
        tvConfirmation = (TextView) findViewById(R.id.tvConfirmation);
        tvThanks = (TextView) findViewById(R.id.tvThanks);
        llNumberPeople = (LinearLayout) findViewById(R.id.llNumberPeople);
        llRestaurantScreen = (LinearLayout) findViewById(R.id.llRestaurantScreen);
        rvOrderList = (RecyclerView) findViewById(R.id.rvOrderList);
    }

    private void setFont() {
        Typeface typefaceRegular = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvRestauarntName.setTypeface(typefaceBold);
        tvReturnToHome.setTypeface(typefaceBold);
        tvLocationLeft.setTypeface(typefaceRegular);
        tvLocation.setTypeface(typefaceRegular);
        tvDateBookedLeft.setTypeface(typefaceRegular);
        tvDateBooked.setTypeface(typefaceRegular);
        tvTimeBookedLeft.setTypeface(typefaceRegular);
        tvNumberofPeopleLeft.setTypeface(typefaceRegular);
        tvTimeBooked.setTypeface(typefaceRegular);
        tvNumberofPeople.setTypeface(typefaceRegular);
        tvConfirmation.setTypeface(typefaceRegular);
        tvThanks.setTypeface(typefaceRegular);
    }

    private void setListeners() {
        tvReturnToHome.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvReturnToHome:
                SetTimerClass.savedList.clear();
                intent = new Intent(context, NewHomeScreenActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        SetTimerClass.savedList.clear();
        intent = new Intent(context, NewHomeScreenActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
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
