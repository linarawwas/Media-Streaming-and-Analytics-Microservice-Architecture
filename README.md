This is An asignment i made while applying for a Mid-Senior Backend Position at Podeo, the prompt of the asignment included making 2 microservices with various API endpoints for specific purposes.

The following requirements are all applied in the application.

I. Media Streaming Microservice:
This publicly accessible service is designed to stream an audio MP3 file to users upon
accessing a specific URL corresponding to the desired audio episode. Certain episodes may
be set as private, requiring authentication for streaming, which can be achieved either
through header authentication or via a signed URL.
Deliverables:
1. Exposing the following endpoints through a REST API, with the APIs being secured using
token authentication
a. An Endpoint to add an episode to the database has:
i. MP3 URL: The URL of the file that will be streamed through the media
service
ii. Name: The name of the episode
iii. Author: The name of the author of the episode
b. An Endpoint to flag an episode as private. A Private episode can only be
streamed through an authenticated route or with a signed URL.
i. This endpoint should be secured for only admin-level authentication.
c. An Endpoint to get a signed URL for a private episode. The signed URL should
have a maximum time to live of 1 hour from the time of creation.
2. Exposing a URL path to be able to stream an mp3 file(The path should stream the file
rather than just serving it to the user. The Service should read the file and stream it
back to the user)
a. The route should take into account authentication headers or a signed URL to
stream private episodes.
b. If the episode is flagged as private and no authentication method is provided
(Header token OR Signed URL) an error should be returned to the user.
c. The service should cache the files into local storage if an episode is requested
multiple times.
d. The service should call the analytics service API endpoint to add an entry in the
database that this episode was requested, the call should be authenticated
and in a fire-and-forget methodology.
II. Analytics Service:
This internally accessible service is designed to take heavy loads of API calls to store analytics
information in the database for every episode that is streamed through the Media service
Deliverables:
1. Exposing the following endpoints through a REST API, with the APIs being secured using
token authentication.
a. An Endpoint to add stream logs into the database, the logs are up to you to
add what seems fit as streaming logs of audio/episode files.
b. The Service should insure no data is lost due to high traffic, the service should
implement any kind of event or queuing mechanism to ensure all data is
stored in the appropriate databases.
Containerization:
The services should be dockerized utilizing a docker file that insures a functioning service by
just deploying the docker file.