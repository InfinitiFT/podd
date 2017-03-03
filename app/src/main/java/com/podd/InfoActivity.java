package com.podd;

import android.content.Context;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;

public class InfoActivity extends AppCompatActivity {
    private Context mContext=InfoActivity.this;
    private TextView tvInfoMsgOne;
    private TextView tvInfoMsgTwo;
    private TextView tvInfoMsgThree;
    private TextView tvInfo;
    private TextView tvInfoDisclaimer;
    private TextView tvInfoLink;
    private TextView tvHeader;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);
        getID();
        setFont();
    }

    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvInfoMsgOne.setTypeface(typeface);
        tvInfoMsgTwo.setTypeface(typeface);
        tvInfoMsgThree.setTypeface(typeface);
        tvInfo.setTypeface(typeface);
        tvInfoDisclaimer.setTypeface(typeface);
        tvInfoLink.setTypeface(typeface);
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvHeader.setTypeface(typefaceBold);
    }
    private void getID() {
        tvInfoMsgOne = (TextView) findViewById(R.id.tvInfoMsgOne);
        tvInfoMsgTwo = (TextView) findViewById(R.id.tvInfoMsgTwo);
        tvInfoMsgThree = (TextView) findViewById(R.id.tvInfoMsgThree);
        tvInfo = (TextView) findViewById(R.id.tvInfo);
        tvInfoDisclaimer = (TextView) findViewById(R.id.tvInfoDisclaimer);
        tvInfoLink = (TextView) findViewById(R.id.tvInfoLink);
        tvHeader = (TextView) findViewById(R.id.tvHeader);

    }


}
