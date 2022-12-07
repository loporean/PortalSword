using UnityEngine;
using UnityEngine.UI;
public class leaderboard : MonoBehaviour
{
    public string Url;

    public void Open()
    {
        Application.OpenURL(Url);
    }
}
