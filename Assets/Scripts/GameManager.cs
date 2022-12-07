using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
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
    public FloatValue playerCurrentHealth;
    public Button restartButton;
    public bool reset = false;
    GameObject[] enemies;
    private void Start()
    {
        Reset();
        
    }
    public void CompleteLevel() {
        completeLevelUI.SetActive(true);
    }

    public void EndGame()
    {
        if (reset == true) { 
            gameHasEnded = false;
            reset = false;
        }
        // target = GameObject.FindWithTag("Player").transform;
        if (playerCurrentHealth.RuntimeValue > 0)
        {
            //Debug.Log("Player is Alive");
        }
        if (playerCurrentHealth.RuntimeValue <= 0)
        {
           // Debug.Log("Player Is Dead");
            gameHasEnded = true;
        }
        if (gameHasEnded == true)
        {
            //gameHasEnded = true;
            //WaitForSeconds(6.0f);
            // if (!reset)
            // {
            //  Debug.Log("Game Ended ");
                gameOverUI.SetActive(true);
                HealthFrameUI.SetActive(false);
                TimerUI.SetActive(false);
                EnemyCounterUI.SetActive(false);
           // }
            //Invoke("Restart", restartDelay);
            //Button btn = restartButton.GetComponent<Button>();
           // btn.onClick.AddListener(restart);

        }
        
    }

    public void restart()
    {
        reset = true;
        //gameHasEnded = false;
        Reset();
        Debug.Log("Game Has Ended" + gameHasEnded);
        SceneManager.LoadScene(SceneManager.GetActiveScene().buildIndex);
     
    }

    public void Reset()
    {
        playerCurrentHealth.RuntimeValue = 6;
        completeLevelUI.SetActive(false);
        gameOverUI.SetActive(false);
        HealthFrameUI.SetActive(true);
        TimerUI.SetActive(true);
        EnemyCounterUI.SetActive(true);
    }

    private void Update()
   {
        enemies = GameObject.FindGameObjectsWithTag("enemy");
        EndGame();
        Victory();
   }

    public void Victory() {
        if (enemies.Length == 0) {
            completeLevelUI.SetActive(true);
            HealthFrameUI.SetActive(false);
            TimerUI.SetActive(false);
            EnemyCounterUI.SetActive(false);
        }
        if(reset == true)
        {
            reset = false;
        }
    }
}
