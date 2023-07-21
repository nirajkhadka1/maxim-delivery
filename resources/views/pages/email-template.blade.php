<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Lora&display=swap');

    body {
        font-family: 'Lora', serif;
    }

    .container {
        height: 100vh;
        width: 100%;
    }

    .main_content {

        margin-inline: auto;
        padding: 20px;
    }

    h2 {
        color: #0052cc;
        font-size: calc(18px + 0.5vw);
    }

    .team {
        display: flex;
        flex-direction: column;
    }

    .bottom_text p {
        text-align: center;
        color: #707070;
    }

    @media (min-width: 700px) {
        .main_content {
            display: flex;
            flex-direction: column;
            justify-self: center;
            align-items: center;
        }

        .top_text,
        .bottom_text {
            text-align: justify;
            max-width: 700px;
        }

        h2 {
            text-align: center;
        }
    }
</style>

<body>
    <div class="container">
        <div class="main_content">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <div class="top_text">

                <h2>
                    Your email is being deactivated.
                </h2>
                <h3>
                    Hi ABC,
                </h3>
                <p>
                    We're reaching out to let you know that your Jira site, bisheshbaj.atlassian.net, is being
                    deactivated
                    due to more than 4 months of inactivity. You will no longer be able to access products, and your
                    data
                    will be permanently deleted soon after.
                </p>
                <p>
                    We’ve also cancelled all subscriptions to Atlassian  apps, including those from Marketplace Partners.
                </p>
                <p>
                    If you need assistance or have questions, please contact us immediately.
                </p>
                <section class="team">
                    <p>Cheers,<br />
                        The Atlassian Team</p>
                </section>
            </div>
            <hr>
            <section class="bottom_text">
                <p>
                    You are receiving this email because this is an important message regarding your account and
                    products you are using. You are not allowed to unsubscribe from this type of message.
                </p>
            </section>
        </div>
    </div>

</body>

</html>
