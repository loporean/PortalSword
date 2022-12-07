using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class E1 : Enemy
{

    private Rigidbody2D myRigidbody;
    public Transform target;
    public float chaseRadius;
    public float attackRadius;
    public Transform homePosition;
    [Header("Animator")]
    public Animator anim;
    private Vector3 change;
    public float speed;
    //public Transform player;
    public bool flip;

    // Start is called before the first frame update
    void Start()
    {
        currentState = EnemyState.idle;
        myRigidbody = GetComponent<Rigidbody2D>();
        anim = GetComponent<Animator>();
        target = GameObject.FindWithTag("Player").transform;
        anim.SetFloat("moveX", 0);
        anim.SetFloat("moveY", -1);
    }

    // Update is called once per frame
    void FixedUpdate()
    {
        CheckDistance();
        //UpdateAnimation();
        //  if (currentState == EnemyState.walk || currentState == EnemyState.idle)
        //  {
        //      UpdateAnimationAndMove();
        //  }

    }
 
    public void UpdateAnimation(Vector2 direction) 
    {
        if (Mathf.Abs(direction.x) > Mathf.Abs(direction.y))
        {
            if (direction.x > 0)
            {
                AnimFloat(Vector2.right);
            }
            else if (direction.x < 0)
            {
                AnimFloat(Vector2.left);
            }
        }
        else if (Mathf.Abs(direction.x) < Mathf.Abs(direction.y))
        {
            if (direction.y > 0)
            {
                AnimFloat(Vector2.up);
            }
            else if (direction.y < 0)
            {
                AnimFloat(Vector2.down);
            }
        }
    }

    public void AnimFloat(Vector2 setVector)
    {
        anim.SetFloat("moveX", setVector.x);
        anim.SetFloat("moveY", setVector.y);
    }

    public virtual void CheckDistance()
    {
        if (Vector3.Distance(target.position, transform.position) <= chaseRadius && Vector3.Distance(target.position, transform.position) > attackRadius)
        {
            //anim.SetBool("Wakeup", true);
            if (currentState == EnemyState.idle || currentState == EnemyState.walk && currentState != EnemyState.stagger)
            {
                
                Vector3 temp = Vector3.MoveTowards(transform.position, target.position, moveSpeed * Time.deltaTime);
                UpdateAnimation(temp - transform.position);
                myRigidbody.MovePosition(temp);
                ChangeState(EnemyState.walk);
                anim.SetBool("Wakeup", true);
                //anim.SetBool("Wakeup", true);
                //anim.SetFloat("moveX", target.position.x);
                //anim.SetFloat("moveY", target.position.y);
                //UpdateAnimation();
            }
        }
        else {
            anim.SetBool("Wakeup", false);
            //anim.SetFloat("moveX", target.position.x);
            //anim.SetFloat("moveY", target.position.y);
            //UpdateAnimation();
            // anim.SetBool("walking", false);
        }
    }

    private void ChangeState(EnemyState newState)
    {
        if (currentState != newState)
        {
            currentState = newState;
        }
    }
}


