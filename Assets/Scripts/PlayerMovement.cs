using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using CodeMonkey.Utils;
using CodeMonkey;


public enum PlayerState{
    walk,
    attack,
    roll,
    interact,
    stagger,
    idle
}

public class PlayerMovement : MonoBehaviour
{

    public PlayerState currentState;
    public float speed;
    private Rigidbody2D myRigidbody;
    private Vector3 change;
    private Animator animator;
    public FloatValue currentHealth;
    public Signals playerHealthSignal;
    private Vector3 slideDir;
    private float slidespeed;


    // Start is called before the first frame update
    void Start()
    {
        currentState = PlayerState.walk;
        animator = GetComponent<Animator>();
        myRigidbody = GetComponent<Rigidbody2D>();
        animator.SetFloat("moveX", 0);
        animator.SetFloat("moveY", -1);
    }

    // Update is called once per frame
    void Update()
    {
        change = Vector3.zero;
        change.x = Input.GetAxisRaw("Horizontal");
        change.y = Input.GetAxisRaw("Vertical");
        if(Input.GetButtonDown("attack") && currentState != PlayerState.attack && currentState != PlayerState.stagger)
        {
            StartCoroutine(AttackCo());
        }
        else if (currentState == PlayerState.walk || currentState == PlayerState.idle)
        {
            UpdateAnimationAndMove();
        }
        switch(currentState) {
            case PlayerState.walk:
                MoveCharacter();
                AttackCo();
                UpdateAnimationAndMove();
                DodgeHandle();
                break;
            case PlayerState.roll:
                StartCoroutine(SlideHandle());
                break;
        }
        
        //Debug.Log(change);
    }

    private IEnumerator AttackCo()
    {
        animator.SetBool("attacking", true);
        currentState = PlayerState.attack;
        yield return null;
        animator.SetBool("attacking", false);
        yield return new WaitForSeconds(.3f);
        currentState = PlayerState.walk;
    }

    void UpdateAnimationAndMove()
    {
         if(change != Vector3.zero)
        {
            MoveCharacter();
            animator.SetFloat("moveX", change.x);
            animator.SetFloat("moveY", change.y);
            animator.SetBool("moving", true);
        }else{
            animator.SetBool("moving", false);
    }
    }

    void MoveCharacter()
    {
        change.Normalize();
        myRigidbody.MovePosition(
            transform.position + change * speed * Time.fixedDeltaTime
        );
    }

    public void Knock(float knockTime, float damage)
    {
        currentHealth.RuntimeValue -=damage;
        playerHealthSignal.Raise();
        if (currentHealth.RuntimeValue > 0)
        {
            //playerHealthSignal.Raise();
            StartCoroutine(KnockCo(knockTime));
        }
        else 
        {
            this.gameObject.SetActive(false);
        }
    }

    private IEnumerator KnockCo(float knockTime)
    {
        if(myRigidbody != null)
        {
            yield return new WaitForSeconds(knockTime);
            myRigidbody.velocity = Vector2.zero;
            currentState = PlayerState.walk;
            myRigidbody.velocity = Vector2.zero;
        }
    }
    private void DodgeHandle(){
        if(Input.GetMouseButtonDown(1)){
            currentState = PlayerState.roll;
            slideDir = (UtilsClass.GetMouseWorldPosition() - transform.position).normalized;
            slidespeed = 50f;
        }
    }
    private IEnumerator SlideHandle(){
        transform.position += slideDir * slidespeed * Time.deltaTime;
        slidespeed -= slidespeed * 10 * Time.deltaTime;
        if(slidespeed < 5f){
            yield return new WaitForSeconds(.5f);
            currentState = PlayerState.walk;
        }
    }
}
