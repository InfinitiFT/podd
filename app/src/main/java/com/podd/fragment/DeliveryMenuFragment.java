package com.podd.fragment;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.podd.R;
import com.podd.adapter.DeliveryMenuAdapter;
import com.podd.adapter.LunchMenuAdapter;
import com.podd.model.MealDetails;
import com.podd.model.RestaurantMenu;

import java.util.ArrayList;
import java.util.List;


public class DeliveryMenuFragment extends Fragment{
    private Context context;
    private View view;
    private RecyclerView rvBreakfastMenu;
    private List<MealDetails> meal_details=new ArrayList<>();
    private List<RestaurantMenu> restaurantMenu=new ArrayList<>();

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        this.context = context;
    }

    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_breakfast_menu, container, false);
        getIds();
        setBreakfastMenu();
        return view;
    }

    private void getIds() {
        rvBreakfastMenu= (RecyclerView) view.findViewById(R.id.rvBreakfastMenu);

    }

    private void setBreakfastMenu() {
        DeliveryMenuAdapter deliveryMenuAdapter = new DeliveryMenuAdapter(context,meal_details,restaurantMenu);
        GridLayoutManager manager = new GridLayoutManager(context, getResources().getInteger(R.integer.grid_span));
        rvBreakfastMenu.setLayoutManager(manager);
        rvBreakfastMenu.setAdapter(deliveryMenuAdapter);
    }


    public Fragment newInstance(List<RestaurantMenu>restaurantMenus,List<MealDetails> meal_details) {
        DeliveryMenuFragment fragment=new DeliveryMenuFragment();
        fragment.restaurantMenu=restaurantMenus;
        fragment.meal_details=meal_details;
        return fragment;
    }
}
