using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public enum EnemyState{
    idle,
    walk,
    attack,
    stagger
}

public class Enemy : MonoBehaviour
{
    [Header("Enemy Stats")]
    public EnemyState currentState;
    public FloatValue maxHealth;
    public float health;
    public string enemyName;  
    public float baseAttack;
    public float moveSpeed;
    public GameObject deathEffect;

    //Hmm
 // public Signal roomSignal;
    private void Awake()
    {
        health = maxHealth.initialValue;
    }

    public void Knock(Rigidbody2D myRigidbody, float knockTime, float damage)
    {
        StartCoroutine(KnockCo(myRigidbody, knockTime));
        TakeDamage(damage);
    }

    private void TakeDamage(float damage)
    {

        health -= damage;
  //    new WaitForSeconds(1f);
        if (health <= 0) {

            Death();
            this.gameObject.SetActive(false);

  //         yield return new WaitForSeconds(1f);
 //         if(roomSignal != null)
 //         {
 //             roomSignal.Raise();
  //       }
            //this.gameObject.SetActive(false);
        }

    }

    private void Death() {
        if (deathEffect != null) 
        {
            GameObject effect = Instantiate(deathEffect, transform.position, Quaternion.identity); ;
            Destroy(effect, 0.5f);
        }
    }

    private IEnumerator KnockCo(Rigidbody2D myRigidbody, float knockTime)
    {
        if(myRigidbody != null)
        {
    //     TakeDamage();
            yield return new WaitForSeconds(knockTime);
            myRigidbody.velocity = Vector2.zero;
            currentState = EnemyState.idle;
            myRigidbody.velocity = Vector2.zero;
      //    if (myRigidbody.velocity == Vector2.zero)
      //    {
      //      TakeDamage();
      //    }
        }
    }

   
}
