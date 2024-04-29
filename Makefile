### Makefile for gerp Project ###

### Author: akaspa02, tarmle01

CXX = clang++
CXXFLAGS = -g3 -Wall -Wextra -Wpedantic -Wshadow
LDFLAGS = -g3

gerp: $(OBJS) FSTree.o DirNode.o
	$(CXX) $(LDFLAGS) -o gerp $(OBJS) FSTree.o DirNode.o

main.o: main.cpp GerpIndex.h QueryProcessor.h
	$(CXX) $(CXXFLAGS) -c main.cpp

GerpIndex.o: GerpIndex.cpp GerpIndex.h FSTree.h processing.h DirNode.h hashmap.h
	$(CXX) $(CXXFLAGS) -c GerpIndex.cpp

QueryProcessor.o: QueryProcessor.cpp QueryProcessor.h GerpIndex.h
	$(CXX) $(CXXFLAGS) -c QueryProcessor.cpp

processing.o: processing.cpp processing.h FSTree.h DirNode.h
	$(CXX) $(CXXFLAGS) -c processing.cpp

hashmap.o: hashmap.cpp hashmap.h ColisionTree.h WordNode.h
	$(CXX) $(CXXFLAGS) -c hashmap.cpp

ColisionTree.o: ColisionTree.cpp ColisionTree.h WordNode.h
	$(CXX) $(CXXFLAGS) -c ColisionTree.cpp

WordNode.o: WordNode.cpp WordNode.h
	$(CXX) $(CXXFLAGS) -c WordNode.cpp

clean:
	@find . -type f \( \
		-name '*.o' ! -name 'FSTree.o' ! -name 'DirNode.o' \
	\) -exec rm -f {} \;
	@rm -f gerp *~ a.out
