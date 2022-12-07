using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class GameManager : MonoBehaviour
{
    bool gameHasEnded = false;
    public float restartDelay = 1f;
    //public FloatValue playerHealth;
    public GameObject completeLevelUI;
    public GameObject gameOverUI;
    public GameObject HealthFrameUI;
    public GameObject TimerUI;
    public GameObject EnemyCounterUI;
    //public Transform target;
    private void Start()
    {
        completeLevelUI.SetActive(false);
        gameOverUI.SetActive(false);
        HealthFrameUI.SetActive(true);
        TimerUI.SetActive(true);
        EnemyCounterUI.SetActive(true);
    }
    public void CompleteLevel() {
        completeLevelUI.SetActive(true);
    }

    public void EndGame()
    {
        // target = GameObject.FindWithTag("Player").transform;
        if (GameObject.FindWithTag("Player").activeSelf == true)
        {
            //Debug.Log("Player is Alive");
        }
        if (GameObject.FindWithTag("Player").activeSelf == false)
        {
           // Debug.Log("Player Is Dead");
            gameHasEnded = true;
        }
        if (gameHasEnded == true)
        {
                    //gameHasEnded = true;
                    //WaitForSeconds(6.0f);
                    gameOverUI.SetActive(true);
                    HealthFrameUI.SetActive(false);
                    TimerUI.SetActive(false);
                    EnemyCounterUI.SetActive(false);
                    Invoke("Restart", restartDelay);
        }
            

        
    }

    void Restart()
    {
        SceneManager.LoadScene(SceneManager.GetActiveScene().name);
    }

  // private void Update()
  // {
 //       EndGame();
  // }

}
