package com.podd.location;

import org.json.JSONObject;

/**
 * Created by abhishek.tiwari on 7/9/15.
 */
public abstract class LocationState {
    public abstract  void onSuccess(JSONObject response);
}
