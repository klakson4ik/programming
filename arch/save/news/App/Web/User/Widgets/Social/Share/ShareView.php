<?php
namespace App\Web\User\Widgets\Social\Share;
$share = Share::getShare();
?>

<div class="share">
 <a
    class="facebook"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://www.facebook.com/sharer.php?u=<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Facebook"><img class="facebook-icon share-icons" src="/icons/facebook.svg" alt="facebook"></a>
 <a
    class="twitter"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://twitter.com/intent/tweet?text=<?php echo $share['title']; ?>&url=<?php echo $share['url']; ?>&via=<?php echo $share['login']; ?>&hashtags=<?php echo $share['tags']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Twitter"><img class="twitter-icon share-icons" src="/icons/twitter.svg" alt="twitter"></a>
 <a
    class="linkedin"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Linkedin"><img class="linkedin-icon share-icons" src="/icons/linkedin.svg" alt="linkedin"></a>
 <a
    class="pinterest"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Pinterest"><img class="pinterest-icon share-icons" src="/icons/pinterest.svg" alt="pinterest"></a>
 <a
    class="reddit"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://reddit.com/submit?url=<?php echo $share['url']; ?>&title<?php echo $share['title']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Reddit"><img class="reddit-icon share-icons" src="/icons/reddit.svg" alt="reddit"></a>
 <a
    class="whatsapp"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://api.whatsapp.com/send?text=<?php echo $share['title']; ?>%20&url<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Whatsapp"><img class="whatsapp-icon share-icons" src="/icons/whatsapp.svg" alt="whatsapp"></a>
 <a
    class="telegram"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://t.me/share/url?url=<?php echo $share['url']; ?>&text<?php echo $share['title']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Telegram"><img class="telegram-icon share-icons" src="/icons/telegram.svg" alt="telegram"></a>
 <a
    class="livejournal"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('http://www.livejournal.com/update.bml?subject=<?php echo $share['title']; ?>&event<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Livejournal"><img class="livejournal-icon share-icons" src="/icons/livejournal.svg" alt="livejournal"></a>
 <a
    class="tumblr"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $share['url']; ?>&title<?php echo $share['title']; ?>&caption=<?php echo $share['description']; ?>&tags=<?php echo $share['tags']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Tumblr"><img class="tumblr-icon share-icons" src="/icons/tumblr.svg" alt="tumblr"></a>
 <a
    class="blogger"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://www.blogger.com/blog-this.g?u=<?php echo $share['url']; ?>&n<?php echo $share['title']; ?>&t=<?php echo $share['description']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Blogger"><img class="blogger-icon share-icons" src="/icons/blogger.svg" alt="blogger"></a>
 <a
    class="getpocket"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://getpocket.com/edit?url=<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Getpocket"><img class="getpocket-icon share-icons" src="/icons/pocket.svg" alt="getpocket"></a>
 <a
    class="googleplus"
    rel="nofollow"
    href="javascript: void(0)"
    onClick="window.open('https://plus.google.com/share?url=<?php echo $share['url']; ?>','sharer','status=0,toolbar=0,width=650,height=500');"
    title="Share Google+"><img class="googleplus-icon share-icons" src="/icons/googleplus.svg" alt="googleplus"></a>
</div>
