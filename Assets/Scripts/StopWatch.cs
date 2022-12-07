using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using System;

public class StopWatch : MonoBehaviour
{
    bool stopwatchActive = false;
    public float currentTime;
    public Text currentTimeText;
    public Text VictoryTimeText;
    GameObject[] enemies;
    // Start is called before the first frame update


    void Start()
    {
        stopwatchActive = true;
        currentTime = 0;
    }

    // Update is called once per frame
    void Update()
    {
        enemies = GameObject.FindGameObjectsWithTag("enemy");
        if (enemies.Length == 0)
        {
            stopwatchActive = false;
            
        }

        if (stopwatchActive == true)
        {
            currentTime = currentTime + Time.deltaTime;
        }
        TimeSpan time = TimeSpan.FromSeconds(currentTime);
        currentTimeText.text = time.ToString(@"hh\:mm\:ss\:ff");
        VictoryTimeText.text = currentTimeText.text;

    }

    public void StartTimer() {
    }

    public void StopTimer() {

    }
}
