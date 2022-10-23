/**
 * Service to list all available movies
 *
 * @return The collection of movies ID and name as JSON response
 */
@RequestMapping(value = "/movies", method = GET, produces = {MediaType.APPLICATION_JSON_VALUE})
public Map<String, String> listAllMovies() {
    Map<String, String> result = new HashMap<>();

    try {
        this.movies.forEach(m -> {
            try {
                //Compute the front end ID for the current element
                String frontEndId = IDORUtil.computeFrontEndIdentifier(m.getBackendIdentifier());
                //Add the computed ID and the associated item name to the result map
                result.put(frontEndId, m.getName());
            } catch (Exception e) {
                LOGGER.error("Error during ID generation for real ID {}: {}", m.getBackendIdentifier(),
                             e.getMessage());
            }
        });
    } catch (Exception e) {
        //Ensure that in case of error no item is returned
        result.clear();
        LOGGER.error("Error during processing", e);
    }

    return result;
}

/**
 * Service to obtain the information on a specific movie
 *
 * @param id Movie identifier from a front end point of view
 * @return The movie object as JSON response
 */
@RequestMapping(value = "/movies/{id}", method = GET, produces = {MediaType.APPLICATION_JSON_VALUE})
public Movie obtainMovieName(@PathVariable("id") String id) {

    //Search for the wanted movie information using Front End Identifier
    Optional<Movie> movie = this.movies.stream().filter(m -> {
        boolean match;
        try {
            //Compute the front end ID for the current element
            String frontEndId = IDORUtil.computeFrontEndIdentifier(m.getBackendIdentifier());
            //Check if the computed ID match the one provided
            match = frontEndId.equals(id);
        } catch (Exception e) {
            //Ensure that in case of error no item is returned
            match = false;
            LOGGER.error("Error during processing", e);
        }
        return match;
    }).findFirst();

    //We have marked the Backend Identifier class field as excluded
    //from the serialization
    //So we can send the object to front end through the serializer
    return movie.get();
}
